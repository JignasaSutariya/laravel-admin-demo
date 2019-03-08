<?php

namespace App\DataTables;

use App\Product;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;

class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('action', function ($product) {
            return '<a class="label label-success" href="' . url('admin/products/'.$product->product_id.'/edit') . '"  title="View"><i class="fa fa-edit"></i>&nbsp</a>
            <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$product->product_id.')"><i class="fa fa-trash"></i>&nbsp</a>';
        })
        ->editColumn('created_at', function($product) {
            return GlobalHelper::getFormattedDate($product->created_at);
        })
        ->addColumn('sub_categories', function($product) {
            $sub_categories = array();
            foreach ($product->sub_category as $sub_category) {
                $sub_categories[] = $sub_category->name;
            }
            return $sub_categories;
        })
        ->filterColumn('sub_categories', function($query, $keyword) {
             $query->whereHas('sub_category', function($q) use($keyword){
                 $sql = 'sub_categories.name like ?';
                 $q->whereRaw($sql, ["%{$keyword}%"]);
             });
        })
        ->rawColumns(['action', 'category']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->select('sub_category_ids', 'name', 'price', 'status', 'created_at', 'updated_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'sub_category_ids',
            'name',
            'price',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_' . date('YmdHis');
    }
}
