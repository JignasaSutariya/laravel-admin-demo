<?php

namespace App\DataTables;

use App\Category;
use Yajra\DataTables\Services\DataTable;
use App\Helper\GlobalHelper;

class CategoryDataTable extends DataTable
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
        ->addColumn('action', function ($category) {
            return '<a class="label label-primary" href="' . url('admin/categories/'.$category->category_id) . '"  title="View"><i class="fa fa-eye"></i>&nbsp</a>
            <a class="label label-success" href="' . url('admin/categories/'.$category->category_id.'/edit') . '"  title="View"><i class="fa fa-edit"></i>&nbsp</a>
            <a class="label label-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$category->category_id.')"><i class="fa fa-trash"></i>&nbsp</a>';
        })
        ->editColumn('created_at', function($category) {
            return GlobalHelper::getFormattedDate($category->created_at);
        })
        ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery()->select('category_id', 'name', 'status', 'created_at', 'updated_at');
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
            'category_id',
            'name',
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
        return 'Category_' . date('YmdHis');
    }
}
