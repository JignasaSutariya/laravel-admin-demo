@extends('admin.layouts.adminMaster')

@section('title')
Country |
@endsection

@section('content')
    <div class="content-wrapper">

        {{--  add new modal for country --}}
        <div class="modal fade" id="countryModal" role="dialog" aria-labelledby="countryModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="countryModalLabel">New Country</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="countryForm" role="form" action="{{url('admin/countries')}}" method="post" enctype="multipart/form-data" >
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('short_code') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="short_code">Short Code <span class="colorRed"> *</span></label>
                                <div class="col-sm-8 jointbox">
                                    <input type="type" class="form-control" name="short_code" maxlength="2" placeholder="Short Code" value="{{old('short_code')}}"/>
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
                                    <input type="type" class="form-control" name="country_name" placeholder="Country Name" value="{{old('country_name')}}"/>
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
                                    <input type="number" class="form-control" placeholder="Phonecode" name="phonecode" max="500000" value="{{old('phonecode')}}"/>
                                    @if ($errors->has('phonecode'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('phonecode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="countryCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--  add new modal for state--}}
        <div class="modal fade" id="stateModal" role="dialog" aria-labelledby="stateModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="stateModalLabel">New State</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="stateForm" role="form" action="{{url('admin/state/new')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('state_country') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="state_country">Country <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <select name="state_country" id="state_country" class="form-control">
                                        <option></option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="country-error"></div>
                                    @if ($errors->has('state_country'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('state_country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('state_name') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="state_name">State Name <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="state_name" name="state_name" placeholder="State Name" value="{{old('state_name')}}"/>
                                    @if ($errors->has('state_name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('state_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="stateCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--  add new modal for city  --}}
        <div class="modal fade" id="cityModal" role="dialog" aria-labelledby="cityModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="cityModalLabel">New City</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="cityForm" role="form" action="{{url('admin/city/new')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('city_country') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="city_country">Country <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <select name="city_country" id="city_country" class="form-control">
                                        <option></option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                        @endforeach
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
                                    <select name="city_state" id="city_state" class="form-control">
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
                                    <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name" value="{{old('city_name')}}"/>
                                    @if ($errors->has('city_name'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('city_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="cityCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Country</h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Country</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row margin-bottom">
                <div class="col-sm-2 pull-right">
                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#countryModal">New Country</button>
                </div>

                <div class="col-sm-2 pull-right">
                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#stateModal">New State</button>
                </div>

                <div class="col-sm-2 pull-right">
                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#cityModal">New City</button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Short Name</th>
                                        <th>Name</th>
                                        <th>Phone Code</th>
                                        <th>Action</th>
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
        .form-group .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('script')
    <script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
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
                @if($errors->has('short_code') || $errors->has('country_name') || $errors->has('phonecode'))
                    $('#countryModal').modal('show');
                @elseif ($errors->has('state_country') || $errors->has('state_name'))
                    $('#stateModal').modal('show');
                @elseif ($errors->has('city_country') || $errors->has('city_name') || $errors->has('city_state'))
                    $('#cityModal').modal('show');
                @endif
            });
        </script>
    @endif

    <script>

        $(document).ajaxStart(function() { Pace.restart(); });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        $(document).ready(function() {
            $("#state_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_state").select2({
                placeholder: "Select a State",
                allowClear: true,
            });
        });

        $('#city_country').on('change', function(){

            var id = $('#city_country').val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getState',
                data: {
                    id
                },
                success: function(data) {
                    $('#city_state').html(data);
                }
            });
        });

        $(function() {
            $('#example1').DataTable({
                stateSave: true,
                "scrollX": false,
                processing: true,
                serverSide: true,
                //searchDelay: 1000,
                ajax: SITE_URL + '/admin/ajaxCountry',
                columns: [
                    {data: 'country_id', name: 'country_id'},
                    {data: 'sortname', name: 'sortname'},
                    {data: 'name', name: 'name'},
                    {data: 'phonecode', name: 'phonecode'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        $(document.body).on('click', "#countryCreateBtn", function(){
            if ($("#countryForm").length){
                $("#countryForm").validate({
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

        $(document.body).on('click', "#stateCreateBtn", function(){
            if ($("#stateForm").length){
                $("#stateForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "state_country":{
                            required:true,
                        },
                        "state_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "state_country":{
                            required:"@lang('messages.country_state_city.country')",
                        },
                        "state_name":{
                            required:"@lang('messages.country_state_city.stateName')",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'state_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });

        $(document.body).on('click', "#cityCreateBtn", function(){
            if ($("#cityForm").length){
                $("#cityForm").validate({
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

        function deleteConfirm(id){
            bootbox.confirm({
            message: "<p class='text-red'>Are you sure you want to delete ?</p><p class='text-red'>It will delete all the related states and cities.</p>",
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
                            url: SITE_URL + '/admin/country/delete/'+id,
                            success: function (data) {
                                toastr.warning('Country Deleted !!');
                                $('#example1').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                }
            })
        }

    </script>
@endsection
