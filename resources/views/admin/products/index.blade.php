@section('title')
Categories |
@endsection
@extends('admin.layouts.adminMaster')
@section('content')
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>SubCategories</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">SubCategories</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="productTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>SubCategory</th>
                                  <th>Name</th>
                                  <th>Price</th>
                                  <th>Status</th>
                                  <th>Created At</th>
                                  <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('css')
<style>
    .alert{
        padding: 6px !important;
    }
    .actStatus{
        cursor: pointer;
    }
</style>
@endsection
@section('script')

<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
@if(Session::has('message'))
    <script>
        $(function() {
        toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
    </script>
@endif

@if(Session::has('errors'))
    <script>
        $(function() {
        $('#myModal').modal('show');
        });
    </script>
@endif

<script>
    $(document).ajaxStart(function() { Pace.restart(); });
    $(document).ready(function() {
        $("#sub_category_ids").select2({
            placeholder: "Select a SubCategory",
            allowClear: true,
        });
    });
    var SITE_URL = "<?php echo URL::to('/'); ?>";

    $(document.body).on('click', "#createBtn", function(){
        if ($("#ProductForm").length){
            $("#ProductForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                      "name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                      "sub_category_ids":{
                          required:true,
                      },
                      "price":{
                          required:true,
                          number:true,
                          min:1
                      },
                  },
                  messages: {
                      "name":{
                          required:"Please enter Product Name.",
                      },
                      "sub_category_ids":{
                          required:"Please select SubCategory.",
                      },
                      "price":{
                          required:"Please enter Price."
                      },
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'sub_category_ids'){
                            error.insertAfter(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
            });
        }
    });
    $(document.body).on('click', '.actStatus' ,function(event){
        var row = this.id;
        var dbid = $(this).attr('data-sid');

        bootbox.confirm({
        message: "Are you sure you want to change SubCategory status ?",
            buttons: {
            'cancel': {
                label: 'No',
                className: 'btn-danger'
            },
                'confirm': {
                label: 'Yes',
                        className: 'btn-success'
                }
            },
            callback: function(result){
                if (result){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type :'POST',
                        data : {id:dbid},
                        url  : 'categories/status-change',
                        success  : function(response) {

                            if (response == 'Active') {
                                $('#'+row+'').text('Active');
                                $('#'+row+'').removeClass('text-danger');
                                $('#'+row+'').addClass('text-green');
                            }
                            else if(response == 'Deactive') {
                                $('#'+row+'').text('Deactive');
                                $('#'+row+'').removeClass('text-green');
                                $('#'+row+'').addClass('text-danger');
                            }
                        }
                    });
                }
            }
        });
    });

    function deleteConfirm(id){
        bootbox.confirm({
        message: "Are you sure you want to delete ?",
            buttons: {
            'cancel': {
                label: 'No',
                className: 'btn-danger'
            },
                'confirm': {
                label: 'Yes',
                        className: 'btn-success'
                }
            },
            callback: function(result){
                if (result){
                    $.ajax({
                        url: SITE_URL + '/admin/products/delete/'+id,
                        success: function (data) {
                            toastr.warning('Product Deleted !!');
                            $('#subSubCategoryDataTable').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            }
        })
    }

    $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "sort": true,
        "paging": true,
        "pagingType": "full_numbers",
        "autoWidth": true,
        "ajax": {
            "url": "product-ajax-data",
            "dataType": "json",
            "type": "POST",
            "data": {_token: "{{csrf_token()}}"}
        },
        "columns": [
            // {
            //     "data": "ad_image",
            //     'title': 'Image',
            //     'sortable': false,
            //     'orderable': false,
            //      'searchable': false,
            //     'render': function (data, type, row) {
            //         return '<img src="' + data + '" height="60" width="60" />';
            //     }
            // },
            {"data": "product_id", searchable: false},
            {"data": "sub_category_ids"},
            {"data": "name"},
            {"data": "price"},
            {"data": "status", searchable: false},
            {"data": "created_at"},
            {"data": 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[1, 'asc']]
    });
</script>
@endsection
