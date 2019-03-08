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
                    <form class="form-horizontal" id="empForm" action="{{url('admin/users/update')}}" method="post" enctype="multipart/form-data">
                    <div class="col-sm-8">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
                                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="first_name">Full Name <span class="colorRed"> *</span></label>
                                    <div class="col-sm-4 jointbox">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="@if(!empty(old('first_name'))){{old('first_name')}}@else{{$user->first_name}}@endif"/>
                                        @if ($errors->has('first_name'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 ">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="@if(!empty(old('last_name'))){{old('last_name')}}@else{{$user->last_name}}@endif"/>
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
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="@if(!empty(old('email'))){{old('email')}}@else{{$user->email}}@endif"/>
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
                                        <input type="text" class="form-control" id="user_mobile" name="user_mobile" placeholder="Mobile number" value="@if(!empty(old('user_mobile'))){{old('user_mobile')}}@else{{$user->user_mobile}}@endif"/>
                                        @if ($errors->has('user_mobile'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('user_mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="country">DOB </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="dob" name="dob" placeholder="DOB" value="@if(!empty(old('dob'))){{old('dob')}}@else{{$user->dob}}@endif"/>
                                        @if ($errors->has('dob'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('education') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="education">Education </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="education" name="education" placeholder="Education" value="@if(!empty(old('education'))){{old('education')}}@else{{$user->education}}@endif"/>
                                        <span>
                                            e.g. Graduate in computer science from xyz university
                                        </span>
                                        @if ($errors->has('education'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('education') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('work') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="work">Work </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="work" name="work" placeholder="Work" value="@if(!empty(old('work'))){{old('work')}}@else{{$user->work}}@endif"/>
                                        <span>
                                            e.g. Professor at xyz college
                                        </span>
                                        @if ($errors->has('work'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('work') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('short_introduction') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="short_introduction">Short Introduction <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="short_introduction" id="short_introduction" placeholder="Short Introduction" class="form-control" rows="6">{{$user->short_introduction}}</textarea>
                                        <span>
                                            This will be display on your profile page
                                        </span>
                                        @if ($errors->has('short_introduction'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('short_introduction') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="country">Country <span class="colorRed"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="@if(!empty(old('country'))){{old('country')}}@else{{$user->country}}@endif"/>
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
                                      <input type="text" class="form-control" id="state" name="state" placeholder="State" value="@if(!empty(old('state'))){{old('state')}}@else{{$user->state}}@endif"/>
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
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="@if(!empty(old('city'))){{old('city')}}@else{{$user->city}}@endif"/>
                                        @if ($errors->has('city'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label  class="col-sm-4 control-label" for="password">Password</label>
                                    <div class="col-sm-4 jointbox">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{old('password')}}"/>
                                        <span class="help-block">Optional</span>
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
                            </div>
                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" id="cancelBtn">Back</button>
                                <button type="submit" id="updateBtn" class="btn btn-info pull-right">Update</button>
                            </div>
                            <!-- /.box-footer -->

                        </div>
                        <div class="col-sm-4">
                            <div class="profile_class  text-center" style="margin-top: 15px;">
                                <label>User image</label><br>
                                @if($user->profile_image)
                                    <a href="{{ URL::asset('/resources/uploads/profile')}}/{{$user->profile_image}}" data-lightbox="img">
                                        <img class="old_profile_imageSub" src="{{ URL::asset('/resources/uploads/profile')}}/{{$user->profile_image}}" style="border-radius: 50%;object-fit: cover;" height="100" width="100"/>
                                    </a>
                                @else
                                    <img class="old_profile_imageSub" src="{{ URL::asset('/resources/assets/img/user.png')}}" style="border-radius: 50%;" height="100" width="100"/>
                                @endif
                                <input class="profile_image_showInput" type="file" id="profile_image" name="profile_image" accept="image/*" onchange="readURL(this);" aria-required="true" aria-label="Close">
                                <span class="changeImage profilechangeImage"><i class="fa fa-edit"></i>Change Image</span>
                            </div>
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
<script src="{{ URL::asset('/resources/assets/admin/plugins/lightbox2-master/dist/js/lightbox.js')}}"></script>

<script>
    $("#cancelBtn").click(function () {
        window.location.href = "{{url('admin/users')}}";
    });

    $(document.body).on('click', "#updateBtn", function(){

        if ($("#empForm").length){
            $("#empForm").validate({
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
                          email:true
                        },
                        "user_mobile":{
                          required:true,
                            number:true,
                            minlength:10,
                            maxlength:15
                        },
                        "dob":{
                          required:true,
                        },
                        "password":{
                          minlength: 6,
                          maxlength: 20
                        },
                        "confirm_password":{
                          equalTo:'#password',
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
                        'short_introduction': {
                            required: true,
                            minlength: 2
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
                            equalTo: "@lang('messages.registrationpage.reqEqualConPass')",
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
                        'short_introduction': {
                            required: "Please write your short introduction",
                            minlength: "Your Introduction must consist of at least 2 characters"
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
      format: 'dd-MM-yyyy',
      autoclose:true,
      endDate: "today",
      maxDate: today
    });
    var SITE_URL = "<?php echo URL::to('/'); ?>";
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

<script>
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
</script>
@endsection
