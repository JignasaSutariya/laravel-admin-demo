@section('title')
State |
@endsection
@extends('admin.layouts.adminMaster')
@section('content')
    <div class="content-wrapper">
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
                                    <input type="hidden" name="state_country" value="{{$country->country_id}}">
                                    <select id="state_country" class="form-control" disabled>
                                        <option></option>
                                        <option value="{{ $country->country_id }}" selected>{{ $country->name }}</option>
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

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>State</h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/countries')}}"><i class="fa fa-dashboard"></i> Country</a></li>
                <li class="active">State</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-sm-2 pull-right" style="padding-bottom: 10px;">
                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#stateModal">New State</button>
                </div>

                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="stateDatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>State Name</th>
                                        <th>Country Name</th>
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
                $('#stateModal').modal('show');
            });
        </script>
    @endif

    <script>
        $(document).ajaxStart(function() { Pace.restart(); });

        var SITE_URL = "<?php echo URL::to('/'); ?>";

        $(function() {
            $('#stateDatatable').DataTable({
                stateSave: true,
                "scrollX": false,
                processing: true,
                serverSide: true,
                //searchDelay: 1000,
                ajax: SITE_URL + "/admin/ajaxState/{{ $country->country_id }}",
                columns: [
                    {data: 'state_id', name: 'state_id'},
                    {data: 'name', name: 'name'},
                    {data: 'country', name: 'country'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        function deleteConfirm(id){
            bootbox.confirm({
            message: "<p class='text-red'>Are you sure you want to delete ?</p><p class='text-red'>It will delete all the related cities.</p>",
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
                            url: SITE_URL + '/admin/state/delete/'+id,
                            success: function (data) {
                                toastr.warning('State Deleted !!');
                                $('#stateDatatable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                }
            })
        }

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

    </script>
@endsection
