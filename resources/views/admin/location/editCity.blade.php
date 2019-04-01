@section('title')
Edit City |
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/resources/assets/admin/plugins/lightbox2-master/dist/css/lightbox.css')}}">
@endsection
@extends('admin.layouts.adminMaster') @section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit City</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/state/view').'/'.$state->state_id}}"><i class="fa fa-dashboard"></i> City</a></li>
            <li class="active">City Edit</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <!-- Horizontal Form -->
                <div class="box ">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" id="editCityForm" action="{{url('admin/city/'.$city->city_id)}}" method="post" enctype="multipart/form-data">
                    <div class="col-sm-8">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('city_country') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="city_country">Country <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="city_country" value="{{ $country->country_id }}">
                                        <select id="city_country" class="form-control" disabled>
                                            <option></option>
                                            <option value="{{ $country->country_id }}" selected>{{ $country->name }}</option>
                                        </select>
                                        <div class="country-error"></div>
                                        @if ($errors->has('city_country'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('city_country') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('city_state') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="city_state">State <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="city_state" value="{{ $state->state_id }}">
                                        <select id="city_state" class="form-control" disabled>
                                            <option></option>
                                            <option value="{{ $state->state_id }}" selected>{{ $state->name }}</option>
                                        </select>
                                        <div class="state-error"></div>
                                        @if ($errors->has('city_state'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('city_state') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('city_name') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="city_name">City <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name" value="@if(!empty(old('city_name'))){{old('city_name')}}@else{{$city->name}}@endif"/>
                                        @if ($errors->has('city_name'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('city_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" id="cancelBtn">Back</button>
                                <button type="submit" id="updateCityBtn" class="btn btn-info pull-right">Update</button>
                            </div>
                            <!-- /.box-footer -->

                        </div>
                    </form>
                    <div class="clearfix"></div>

                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

</div>
@endsection

@section('css')
    <style>
        .form-group .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('script')
    @if(Session::has('message'))
        <script>
            $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
            });
        </script>
    @endif

    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
    <script>
        $("#cancelBtn").click(function () {
            window.location.href = "{{url('admin/city')}}";
        });

        $(document.body).on('click', "#updateCityBtn", function(){
            if ($("#editCityForm").length){
                $("#editCityForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "city_country":{
                            required:true,
                        },
                        "city_state":{
                            required:true,
                        },
                        "city_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "city_country":{
                            required:"@lang('messages.country_state_city.cityCountry')",
                        },
                        "city_state":{
                            required:"@lang('messages.country_state_city.cityState')",
                        },
                        "city_name":{
                            required:"@lang('messages.country_state_city.cityName')",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'city_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else if(element.attr("name") == 'city_state'){
                            element.closest('.form-group ').find(".state-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

    </script>
@endsection
