<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\DataTables\ProductDataTable;
use App\Product;
use App\SubCategory;
use DB;
use Session;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ProductDataTable $dataTable)
    {
        $html = $builder->columns([
            ['data' => 'product_id', 'name' => 'product_id','title' => 'ID'],
            ['data' => 'sub_categories', 'sub_categories' => 'name','title' => 'SubCategory'],
            ['data' => 'name', 'name' => 'name','title' => 'Name'],
            ['data' => 'price', 'name' => 'price','title' => 'Price'],
            ['data' => 'status', 'name' => 'status','title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at','title' => 'Created At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false,'title' => 'Action'],
        ]);

        if(request()->ajax()) {
            $users = Product::where('products.status', '=', '1');
            return $dataTable->dataTable($users)->toJson();
        }

        //get list of all sub-categories
        $subcategories = SubCategory::where('status','1')->get();

        return view('admin.products.list', compact('html', 'subcategories'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:40',
            'sub_category_ids' => 'required|exists:sub_categories,sub_category_id'
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->sub_category_ids = $request->sub_category_ids;
            if($product->save()) {
                Session::flash('message', 'Product added succesfully!');
                Session::flash('alert-class', 'success');
                return redirect()->back();
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrfail($id);

        //get list of all sub-categories
        $subcategories = SubCategory::where('status','1')->get();

        return view('admin.products.view', compact('product', 'subcategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrfail($id);
        //get list of all sub-categories
        $subcategories = SubCategory::where('status','1')->get();
        return view('admin.products.edit', compact('product', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules = [
            'name' => 'required|min:2|max:40',
            'category_id' => 'required|exists:categories'
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            if($product->save()) {
                Session::flash('message', 'Product updated succesfully!');
                Session::flash('alert-class', 'success');
                return redirect('admin/sub-categories');
            } else {
                Session::flash('message', 'Oops !! Something went wrong!');
                Session::flash('alert-class', 'error');
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::destroy($request->id);
        return '1';
    }

    public function productList(){
        return view('admin.products.index');
    }

    public function productAjaxData(Request $request)
    {
       $columns = array(
                            0 =>'product_id',
                            1 =>'sub_category_ids',
                            2 =>'name',
                            3 =>'price',
                            4 =>'status',
                            5 =>'created_at',
                            6 =>'action',
                        );
        $products = Product::where('status','1')->get();
        $totalData = count($products);

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
          $productsList = Product::where('status','1')
                       ->offset($start)
                       ->limit($limit)
                       ->orderBy($order,$dir)
                       ->get();
        }
        else {
            $search = $request->input('search.value');

            $productsList = Product::where('status','1')
     					->where('name','LIKE',"%{$search}%")
     					->orWhere('price', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = count($productsList);
        }

        $data = array();
        if(!empty($productsList))
        {
            foreach ($productsList as $product)
            {
                $nestedData['product_id'] = $product->product_id;
                $nestedData['sub_category_ids'] = $product->sub_category_ids;
                $nestedData['name'] = $product->name;
                $nestedData['price'] = $product->price;
                $nestedData['status'] = ($product->status == 1)?'<div id="ad_status_'.$product->product_id.'"><button class="btn btn-block btn-success btn-sm ad_status_click" style="width:60px; height:20px; padding:0px;" type="button" name="ad_status_'.$product->product_id.'" data-id="'.$product->product_id.'"  value="1" >Active</button></div>':'<div id="ad_status_'.$product->product_id.'"><button class="btn btn-block btn-danger btn-sm ad_status_click" style="width:60px; height:20px; padding:0px;" type="button" name="ad_status_'.$product->product_id.'" data-id="'.$product->product_id.'" value="0"><span>Deactive</span></button></div>';
                $nestedData['created_at'] = $product['created_at']->toDateTimeString();
                $nestedData['action'] = '<a href="viewad/'.$product->product_id.'" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-eye" ></i></a>&nbsp;<a href="editad/'.$product->product_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit" ></i></a>&nbsp;<a href="#" class="btn btn-xs" style="color:#ffffff; background-color:red"  data-href="deletead/'.$product->product_id.'" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash" ></i></a>';
                $data[] = $nestedData;

            }
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                    );

        echo json_encode($json_data);
    }

}
