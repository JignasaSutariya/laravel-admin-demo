@section('title')
Categories |
@endsection
@extends('admin.layouts.adminMaster')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit SubCategory</h1>
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
                        <form class="form-horizontal" id="SubCategoryForm" role="form" action="{{url('admin/sub-categories')}}/{{$sub_category->sub_category_id}}" method="post" enctype="multipart/form-data" >
                            {{method_field('PUT')}}
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label  class="col-sm-3 control-label" for="category_id">Category <span class="colorRed"> *</span></label>
                                <div class="col-sm-5">
                                    <div>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option></option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}" @if($category->category_id == $sub_category->category_id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('category_id'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label  class="col-sm-3 control-label" for="name">Name <span class="colorRed"> *</span></label>
                                <div class="col-sm-5 jointbox">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if($sub_category->name) {{$sub_category->name}} @else {{old('name')}} @endif"/>
                                    @if ($errors->has('name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="updateBtn" class="btn btn-info pull-right">Update</button>
                            </div>
                        </form>
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

    var SITE_URL = "<?php echo URL::to('/'); ?>";

    $(document).ready(function() {
        $("#category_id").select2({
            placeholder: "Select a Category",
            allowClear: true,
        });
    });

    $(document.body).on('click', "#updateBtn", function(){
        if ($("#SubCategoryForm").length){
            $("#SubCategoryForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                      "name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                      "category_id":{
                          required:true,
                      }
                  },
                  messages: {
                      "name":{
                          required:"Please enter SubCategory Name.",
                      },
                      "category_id":{
                          required:"Please select Category.",
                      }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'category_id'){
                            error.insertAfter(element.closest("div"));
                        }else{
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
            });
        }
    });
</script>
@endsection
