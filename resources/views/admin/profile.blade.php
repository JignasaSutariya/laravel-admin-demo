@extends('admin.layouts.adminMaster')
@section('title')
Profile |
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Update
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#information" data-toggle="tab">Information</a></li>
              <li><a href="#password" data-toggle="tab">Password</a></li>
            </ul>
            <?php $user = Auth::user(); ?>
            <div class="tab-content">
              <div class="active tab-pane" id="information">
                <form class="form-horizontal" id="profileForm" method="post" action="{{url('admin/profile')}}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-5 jointbox">
                      <input type="text" class="form-control" name="first_name" id="first_name" value="{{$user->first_name}}" placeholder="First Name">
                      @if ($errors->has('first_name'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('first_name') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="col-sm-5 ">
                      <input type="text" class="form-control" name="last_name" id="last_name" value="{{$user->last_name}}" placeholder="Last Name">
                      @if ($errors->has('last_name'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('last_name') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control"  name="email" id="email" value="{{$user->email}}" placeholder="eg. abc@gmail.com">
                      @if ($errors->has('email'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="user_mobile" class="col-sm-2 control-label">Phone number</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="user_mobile" id="user_mobile" value="{{$user->user_mobile}}" placeholder="eg. 9904132640">
                      @if ($errors->has('user_mobile'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('user_mobile') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="profile_image" class="col-sm-2 control-label">Profile Photo</label>
                    <div class="col-sm-10">
                      <input type="file" class="" id="profile_image" name="profile_image">
                      @if ($errors->has('profile_image'))
                          <span class="help-block alert alert-danger">
                            <strong>{{ $errors->first('profile_image') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" id="createBtn" class="btn btn-danger">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="password">
                <form class="form-horizontal" id="passwordForm" method="post" action="{{url('admin/password')}}">
                  <div class="form-group">
                    <label for="old_password" class="col-sm-2 control-label">Current</label>
                    <div class="col-sm-10">
                    {{ csrf_field() }}
                      <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Your current password">
                      @if ($errors->has('old_password'))
                          <span class="help-block alert alert-danger">
                            <strong>{{ $errors->first('old_password') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="new_password" class="col-sm-2 control-label">New</label>
                    <div class="col-sm-10">
                      <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password">
                      @if ($errors->has('new_password'))
                          <span class="help-block alert alert-danger">
                            <strong>{{ $errors->first('new_password') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="confirm_password" class="col-sm-2 control-label">Confirm</label>
                    <div class="col-sm-10">
                      <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password">
                      @if ($errors->has('confirm_password'))
                          <span class="help-block alert alert-danger">
                            <strong>{{ $errors->first('confirm_password') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" id="createBtn2" class="btn btn-danger">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

@endsection
@section('script')
@if(Session::has('message'))
    <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
    </script>
@endif
<script>
    $(document).ajaxStart(function() {
        Pace.restart();
    });
</script>

<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/jquery.validate.js')}}"></script>
<script src="{{URL::asset('resources/assets/custom/jQuery-validation-plugin/additional-methods.js')}}"></script>
<script>
  $.validator.addMethod("email", function(value, element) {
    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
  }, "Please enter valid email.");
  $(document.body).on('click', "#createBtn", function(){
      if ($("#profileForm").length){
          $("#profileForm").validate({
                  errorElement: 'span',
                  errorClass: 'text-red',
                  ignore: [],
                  rules: {
                      "first_name":{
                          required:true,
                      },
                      "last_name":{
                          required:true,
                      },
                      "email":{
                          required:true,
                          email:true
                      },
                      "user_mobile":{
                          required:true,
                          number: true,
                          minlength: 10,
                          maxlength: 12
                      },
                  },
                  messages: {
                      "first_name":{
                          required:"Please enter first name."
                      },
                      "last_name":{
                          required:"Please enter last name."
                      },
                      "email":{
                          required:"Please enter email."
                      },
                      "user_mobile":{
                          required:"Please enter mobile no."
                      },
                  },
                  errorPlacement: function(error, element) {
                  error.insertAfter(element.closest(".form-control"));
                  },
          });
      }
  });

  $(document.body).on('click', "#createBtn2", function(){
      if ($("#passwordForm").length){
          $("#passwordForm").validate({
                  errorElement: 'span',
                  errorClass: 'text-red',
                  ignore: [],
                  rules: {
                      "old_password":{
                          required:true,
                      },
                      "new_password":{
                          required:true,
                      },
                      "confirm_password":{
                          required:true,
                          equalTo: "#new_password"
                      },
                  },
                  messages: {
                      "old_password":{
                          required:"Please enter current password."
                      },
                      "new_password":{
                          required:"Please enter new password."
                      },
                      "confirm_password":{
                          required:"Please enter confirm password.",
                          equalTo:"Please enter same as new password."
                      },
                  },
                  errorPlacement: function(error, element) {
                  error.insertAfter(element.closest(".form-control"));
                  },
          });
      }
  });
</script>
@endsection
