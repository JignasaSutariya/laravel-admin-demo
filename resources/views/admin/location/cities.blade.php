@extends('admin.layouts.adminMaster')

@section('title')
City |
@endsection

@section('content')
    <div class="content-wrapper">

        {{--  add new modal  --}}
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">New City</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="cityForm" role="form" action="{{url('admin/city/new')}}" method="post">
                            {{ csrf_field() }}
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

        {{--  <!-- Content Header (Page header) -->  --}}
        <section class="content-header">
            <h1>City</h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/state/view').'/'.$state->country_id}}"><i class="fa fa-dashboard"></i> State</a></li>
                <li class="active">City</li>
            </ol>
        </section>

        {{--  <!-- Main content -->  --}}
        <section class="content">
            <div class="row">

                <div class="col-sm-2 pull-right" style="padding-bottom: 10px;">
                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">New City</button>
                </div>

                <div class="col-xs-12">
                    <div class="box">
                        {{--  <!-- /.box-header -->  --}}
                        <div class="box-body">
                            <table id="cityDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        {{--  <!-- /.box-body -->  --}}
                    </div>
                    {{--  <!-- /.box -->  --}}
                </div>
                {{--  <!-- /.col -->  --}}
            </div>
            {{--  <!-- /.row -->  --}}
        </section>
        {{--  <!-- /.content -->  --}}
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

    <script>
        $(document).ajaxStart(function() { Pace.restart(); });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        $(document).ready(function() {
            $("#city_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_state").select2({
                placeholder: "Select a State",
                allowClear: true,
            });
        });

        $(function() {
            $('#cityDatatable').DataTable({
                stateSave: true,
                "scrollX": false,
                processing: true,
                serverSide: true,
                //searchDelay: 1000,
                ajax: SITE_URL + '/admin/ajaxCity/{{ $state->state_id }}',
                columns: [
                    {data: 'city_id', name: 'city_id'},
                    {data: 'name', name: 'name'},
                    {data: 'state', name: 'state'},
                    {data: 'country', name: 'country'},
                    // {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        $(document.body).on('click', '.actStatus' ,function(event){
            var row = this.id;
            var dbid = $(this).attr('data-sid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type :'POST',
                data : {
                    id:dbid
                },
                url  : SITE_URL+'/admin/city/status-change',
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

        function deleteConfirm(id){
            bootbox.confirm({
            message: "<p class='text-red'>Are you sure you want to delete ?</p>",
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
                            url: SITE_URL + '/admin/city/delete/'+id,
                            success: function (data) {
                                toastr.warning('City Deleted !!');
                                $('#cityDatatable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                }
            })
        }

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

    </script>
@endsection
