<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\DataTables\SubCategoryDataTable;
use App\SubCategory;
use App\Category;
use DB;
use Session;
use Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, SubCategoryDataTable $dataTable)
    {
        $html = $builder->columns([
            ['data' => 'sub_category_id', 'name' => 'sub_category_id','title' => 'ID'],
            ['data' => 'category', 'category' => 'name','title' => 'Category'],
            ['data' => 'name', 'name' => 'name','title' => 'Name'],
            ['data' => 'status', 'name' => 'status','title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at','title' => 'Scaned At'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false,'title' => 'Action'],
        ]);

        if(request()->ajax()) {
            $users = SubCategory::whereHas('category', function($query) {
                $query->where('categories.status', '=', '1');
            })
            ->where('sub_categories.status', '=', '1');
            return $dataTable->dataTable($users)->toJson();
        }

        //get list of all categories
        $categories = Category::where('status','1')->get();
        return view('admin.sub_categories.list', compact('html', 'categories'));
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
            'category_id' => 'required|exists:categories'
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $sub_category = new SubCategory();
            $sub_category->name = $request->name;
            $sub_category->category_id = $request->category_id;
            if($sub_category->save()) {
                Session::flash('message', 'SubCategory added succesfully!');
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
        $sub_category = SubCategory::findOrfail($id);

        //get list of all categories
        $categories = Category::where('status','1')->get();

        return view('admin.sub_categories.view', compact('sub_category', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_category = SubCategory::findOrfail($id);
        //get list of all categories
        $categories = Category::where('status','1')->get();
        return view('admin.sub_categories.edit', compact('sub_category', 'categories'));
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
            $sub_category = SubCategory::find($id);
            $sub_category->name = $request->name;
            $sub_category->category_id = $request->category_id;
            if($sub_category->save()) {
                Session::flash('message', 'SubCategory updated succesfully!');
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
        $sub_category = SubCategory::destroy($request->id);
        return '1';
    }
}
