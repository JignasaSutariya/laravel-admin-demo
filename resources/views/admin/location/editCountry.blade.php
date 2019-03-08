@section('title')
User Detail |
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/resources/assets/admin/plugins/lightbox2-master/dist/css/lightbox.css')}}">
@endsection
@extends('admin.layouts.adminMaster') @section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>User Detail</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('admin/users')}}"> Users</a></li>
            <li class="active">Detail</li>
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
                    <form class="form-horizontal" id="editCountryForm" action="{{url('admin/countries/'.$country->country_id)}}" method="post" enctype="multipart/form-data">
                    <div class="col-sm-8">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('short_code') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="short_code">Short Code <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8 jointbox">
                                        <input type="type" class="form-control" name="short_code" maxlength="2" placeholder="Short Code" value="@if(!empty(old('short_code'))){{old('short_code')}}@else{{$country->sortname}}@endif"/>
                                        @if ($errors->has('short_code'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('short_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('country_name') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="country_name" >Country Name <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8 jointbox">
                                        <input type="type" class="form-control" name="country_name" placeholder="Country Name" value="@if(!empty(old('country_name'))){{old('country_name')}}@else{{$country->name}}@endif"/>
                                        @if ($errors->has('country_name'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('country_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('phonecode') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="phonecode">Phonecode<span class="colorRed"> *</span></label>
                                    <div class="col-sm-8 jointbox">
                                        <input type="number" class="form-control" placeholder="Phonecode" name="phonecode" max="500000" value="@if(!empty(old('phonecode'))){{old('phonecode')}}@else{{$country->phonecode}}@endif"/>
                                        @if ($errors->has('phonecode'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('phonecode') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" id="cancelBtn">Back</button>
                                <button type="submit" id="updateCountryBtn" class="btn btn-info pull-right">Update</button>
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
            window.location.href = "{{url('admin/countries')}}";
        });

        $(document.body).on('click', "#updateCountryBtn", function(){

            if ($("#editCountryForm").length){
                $("#editCountryForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "short_code":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "country_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "phonecode":{
                            required:true,
                            number:true,
                            min:1,
                            minlength:1,
                            maxlength:5
                        },
                    },
                    messages: {
                        "short_code":{
                            required:"@lang('messages.country_state_city.shortCode')",
                        },
                        "country_name":{
                            required:"@lang('messages.country_state_city.countryName')",
                        },
                        "phonecode":{
                            required:"@lang('messages.country_state_city.phoneCode')",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

        var today = new Date();

        $('#dob').datepicker({
            format: 'yyyy-mm-dd',
            autoclose:true,
            endDate: "today",
            maxDate: today
        });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        function readURL(input) {
            var old_profile_image = $('#old_profile_image').val();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.old_profile_imageSub')
                        .attr('src', e.target.result)
                        .width(125)
                        .height(125);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#country').on('change', function(){
            $('#state').html('');
            $('#city').html('');
            var id = $('#country').val();
            var state = {{ !empty($country->state) ? $country->state: 'null' }};
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getState',
                data: {
                    id,
                    state
                },
                success: function(data) {
                    $('#state').html(data);
                }
            });
        });

        $('#state').on('change', function(){
            $('#city').html('');
            var id = $('#state').val();
            var city = {{ (!empty($country->city)) ? $country->city: 'null' }};
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getCity',
                data: {
                    id,
                    city
                },
                success: function(data) {
                    $('#city').html(data);
                }
            });
        });
    </script>
@endsection
