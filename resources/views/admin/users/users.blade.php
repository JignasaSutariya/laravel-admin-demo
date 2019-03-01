@section('title')
Users |
@endsection
@extends('admin.layouts.adminMaster')
@section('content')
<div class="content-wrapper">

    {{--  add new modal  --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New User</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" id="userForm" role="form" action="{{url('admin/users/new')}}" method="post" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="first_name">Full Name <span class="colorRed"> *</span></label>
                            <div class="col-sm-4 jointbox">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{old('first_name')}}"/>
                                @if ($errors->has('first_name'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{old('last_name')}}"/>
                                @if ($errors->has('last_name'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                           <label  class="col-sm-4 control-label" for="email">Email <span class="colorRed"> *</span></label>
                           <div class="col-sm-8">
                               <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}"/>
                               @if ($errors->has('email'))
                               <span class="help-block alert alert-danger">
                                   <strong>{{ $errors->first('email') }}</strong>
                               </span>
                               @endif
                           </div>
                       </div>

                         <div class="form-group {{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="user_mobile">Mobile no <span class="colorRed"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="user_mobile" name="user_mobile" placeholder="Mobile number" value="{{old('user_mobile')}}"/>
                                @if ($errors->has('user_mobile'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('user_mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="dob">DOB <span class="colorRed"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="dob" name="dob" placeholder="DOB" value="{{old('countdobry')}}"/>
                                @if ($errors->has('dob'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="country">Country <span class="colorRed"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="India"/>
                                @if ($errors->has('country'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="state">State <span class="colorRed"> *</span></label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="state" name="state" placeholder="State" value="{{old('state')}}"/>
                              @if ($errors->has('state'))
                              <span class="help-block alert alert-danger">
                                  <strong>{{ $errors->first('state') }}</strong>
                              </span>
                              @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="city">City <span class="colorRed"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{old('city')}}"/>
                                @if ($errors->has('city'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label  class="col-sm-4 control-label" for="password">Password <span class="colorRed"> *</span></label>
                            <div class="col-sm-4 jointbox">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{old('password')}}"/>
                                @if ($errors->has('password'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-sm-4 ">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="{{old('confirm_password')}}"/>
                                @if ($errors->has('confirm_password'))
                                <span class="help-block alert alert-danger">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="createBtn" class="btn btn-info pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-sm-2 pull-right" style="padding-bottom: 10px;">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">New User</button>
            </div>

            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Reg.Using</th>
                                    <th>Acc. Created On</th>
                                    <th>Status</th>
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
    var today = new Date();
    $('#dob').datepicker({
      format: 'dd-MM-yyyy',
      autoclose:true,
      endDate: "today",
      maxDate: today
    });
    var SITE_URL = "<?php echo URL::to('/'); ?>";

    $(function() {
    $('#example1').DataTable({
            //stateSave: true,
            "scrollX": false,
            processing: true,
            serverSide: true,
            //searchDelay: 1000,
            ajax: SITE_URL + '/admin/ajaxUsers',
            columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'user_mobile', name: 'user_mobile'},
            {data: 'registeredUsing', name: 'registeredUsing'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[ 0, "desc" ]]
        });

    });
    $.validator.addMethod("email", function(value, element) {
        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, "Please enter valid email.");
    $(document.body).on('click', "#createBtn", function(){
        if ($("#userForm").length){
            $("#userForm").validate({
            errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                      "first_name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                      "last_name":{
                          required:true,
                          minlength: 2,
                          maxlength: 20
                      },
                      "email":{
                        required:true,
                        email:true,
                          remote: {
                              url: SITE_URL + '/check-email-exsist',
                              type: "get"
                          }
                      },
                      "user_mobile":{
                        required:true,
                          number:true,
                          minlength:10,
                          maxlength:15,
                          remote: {
                              url: SITE_URL + '/check-number-exsist',
                              type: "get"
                          }
                      },
                      "dob":{
                        required:true,
                      },
                      "confirm_password":{
                        required:true,
                        equalTo:'#password',
                      },
                      "password":{
                        required:true,
                        minlength: 6,
                        maxlength: 20
                      },
                      "country":{
                        required:true,
                        minlength: 2,
                        maxlength: 20
                      },
                      "state":{
                        required:true,
                        minlength: 2,
                        maxlength: 20
                      },
                      "city":{
                        required:true,
                        minlength: 2,
                        maxlength: 20
                      },
                  },
                  messages: {
                      "email":{
                          required:"@lang('messages.registrationpage.reqemail')",
                          remote:"@lang('messages.registrationpage.remoteEmail')",
                      },
                        "first_name":{
                          required:"@lang('messages.registrationpage.reqfirstname')",
                      },
                        "last_name":{
                          required:"@lang('messages.registrationpage.reqLastname')",
                      },
                        "user_mobile":{
                          required:"@lang('messages.registrationpage.reqMobileno')",
                          minlength: "@lang('messages.registrationpage.minmobile')",
                            maxlength: "@lang('messages.registrationpage.maxmobile')",
                            remote:"@lang('messages.registrationpage.remoteMobile')",
                      },
                      "dob":{
                        required:"@lang('messages.registrationpage.reqDob')",
                      },
                        "confirm_password":{
                          required:"@lang('messages.registrationpage.reqConPassword')",
                          equalTo: "@lang('messages.registrationpage.reqEqualConPass')",
                      },
                      "password":{
                          required:"@lang('messages.registrationpage.reqPass')",
                      },
                      "country":{
                        required:"@lang('messages.registrationpage.reqCountry')",
                      },
                      "state":{
                        required:"@lang('messages.registrationpage.reqState')",
                      },
                      "city":{
                        required:"@lang('messages.registrationpage.reqCity')",
                      },
                    },
                    errorPlacement: function(error, element) {
                    error.insertAfter(element.closest(".form-control"));
                    },
            });
        }
    });

    $(document.body).on('click', '.actStatus' ,function(event){
        var row = this.id;
        var dbid = $(this).attr('data-sid');

        bootbox.confirm({
        message: "Are you sure you want to change user status ?",
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
                        url  : 'users/status-change',
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
                        url: SITE_URL + '/admin/users/delete/'+id,
                        success: function (data) {
                            toastr.warning('User Deleted !!');
                            $('#example1').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            }
        })
    }

    $(document.body).on('change', "#state", function(){
        var id = $('#state').val();
        if (id != '') {
            $.ajax({
                url: SITE_URL + '/getCity/'+id,
                success: function (data) {
                    if (data != '') {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').append('<option value="">Please select</option>');
                        $.each(data, function (i) {
                            $('select[name="city"]').append('<option value="' + data[i].cityId + '">' + data[i].cityName + '</option>');
                        });

                    } else {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').append('<option value="">Please select</option>');
                    }
                }
            });
        } else {
            $('select[name="city"]').empty();
            $('select[name="city"]').append('<option value="">Please select</option>');
        }

    });
</script>
@endsection
