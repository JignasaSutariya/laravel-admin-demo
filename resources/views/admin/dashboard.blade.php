@extends('admin.layouts.adminMaster')
@section('title')
@endsection
@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small>Admin Dashboard</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Dashboard</li>
      </ol>
	</section>

<section class="content">
	<div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    {{-- <div class="box-header">
                        <h3 class="box-title">Moving Information</h3>
                    </div> --}}
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                        <div class="row">
                          <div class="col-sm-12">
                              <form id="movingForm" class="form-horizontal" role="form" action="{{url('admin/dashboard')}}" method="post" enctype="multipart/form-data" >
                                   {{ csrf_field() }}

                              <div class="col-sm-3">
                                    <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                                      <div class="col-sm-12">
                                        <label for="start_date">From</label>
                                        <input type="text"
                                            class="form-control" name="start_date" id="start_date" value="{{old('start_date')}}"
                                            placeholder="Date" data-provide="datepicker">
                                        @if ($errors->has('start_date'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                    </div>
                              </div>
                              <div class="col-sm-3">
                                    <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                                      <div class="col-sm-12">
                                        <label for="end_date">To</label>
                                        <input type="text"
                                            class="form-control" name="end_date" id="end_date" value="{{old('end_date')}}"
                                            placeholder="Date" data-provide="datepicker">
                                        @if ($errors->has('start_date'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                </div>
                              </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <div class="col-sm-12">
                                      <label class="col-sm-12">&nbsp;</label>
                                      <button type="submit" id="checkBtn" class="btn btn-primary checkBtn">Check</button>
                                      {{-- <a href="" id="exportBtn" class="btn btn-success exportBtn" style="display:none;">Export</a> --}}

                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="" style="display:inline">&nbsp;&nbsp;&nbsp;
                               <a href="javascript:void(0)" onclick="queryByDate(2)">Yesterday</a>&nbsp;|&nbsp;
                               <a href="javascript:void(0)" onclick="queryByDate(3)">This Week</a>&nbsp;|&nbsp;
                               <a href="javascript:void(0)" onclick="queryByDate(4)">Last Week</a>&nbsp;|&nbsp;
                               <a href="javascript:void(0)" onclick="queryByDate(5)">This Month</a>&nbsp;|&nbsp;
							   <a href="javascript:void(0)" onclick="queryByDate(6)">Last Month</a>
							   <a href="javascript:void(0)" onclick="queryByDate(7)"></a>
                           </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
    </div>
    <!-- Main content -->
    <div class="dashboardData">
        <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="usercount"></h3>
                        <p>Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people-outline"></i>
                    </div>
                    <a href="{{url('admin/users')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
    </div>

    <!-- /.content -->
</section>
</div>

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
    $(document).ajaxStart(function() {
        Pace.restart();
    });
</script>

<script>
var SITE_URL = '<?php echo URL::to('/').'/'; ?>';


$(document.body).on('click',"#checkBtn",function(){
	if($("#movingForm").length){
        $("#movingForm").validate({
                onfocusout: false,
                errorElement: 'span',
	            errorClass: 'text-red',
	            ignore: [],
	                rules: {
                        "start_date":{
	                        required:true,
	                    },
                        "end_date":{
	                        required:true,
	                    }
	                },
	                messages: {
                        "start_date":{
	                      required:"Please select from date."
	                    },
                        "end_date":{
	                      required:"Please select to date."
	                    },
	                },
	                errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
	                },
                    submitHandler: function(form,e) {

                        var start_date = $('#start_date').val();
                        var end_date = $('#end_date').val()
                        e.preventDefault();
                        $.ajax({
                        url: SITE_URL + 'admin/dashboardFilterData',
                        type: 'POST',
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}",start_date: start_date,end_date: end_date},
                        success: function (data) {
                            $("#usercount").html(data);
                        }
                    });

	                },

	        });
	    }
});

//queryByDate
function queryByDate(type) {
    var date = new Date()
    // date.setMonth(9);
    Date.prototype.getWeek = function(start)
    {
		start = start || 0;
		var day = date.getDay() - start;
		var date_week = date.getDate() - day;
		var StartDate = new Date(date.setDate(date_week)+1);
		return [StartDate];
    }
    switch (type) {
      case 2:
                var new_date =  new Date (date.setDate(date.getDate()-1));
                date.setDate(date.getDate()+1);
                $("#start_date").val(("0" + (new_date.getMonth() + 1)).slice(-2) +'/' + new_date.getDate() + '/' + new_date.getFullYear());
                $("#end_date").val(("0" + (new_date.getMonth() + 1)).slice(-2) +'/' + new_date.getDate() + '/' + new_date.getFullYear());
                $("#checkBtn").trigger("click");
              break;
      case 3:
                var Dates = new Date().getWeek();
                var new_date = Dates[0];
                $("#start_date").val(("0" + (new_date.getMonth() + 1)).slice(-2) +'/' + (new_date.getDate()+1) + '/' + new_date.getFullYear());
                var current_date = new Date();
                $("#end_date").val(("0" + (current_date.getMonth() + 1)).slice(-2) +'/' + current_date.getDate() + '/' + current_date.getFullYear());
                $("#checkBtn").trigger("click");
              break;
      case 4:
                var Dates = new Date().getWeek();
                var startDate = new Date(Dates[0]);
                var endDate = new Date(Dates[0]);
                startDate.setDate(startDate.getDate()-6);
                endDate.setDate(endDate.getDate());
                $("#start_date").val(("0" + (startDate.getMonth() + 1)).slice(-2) +'/' + startDate.getDate() + '/' + startDate.getFullYear());
                $("#end_date").val(("0" + (endDate.getMonth() + 1)).slice(-2) +'/' + endDate.getDate() + '/' + endDate.getFullYear());
                $("#checkBtn").trigger("click");
              break;
        case 5:
                var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                  $("#start_date").val(("0" + (firstDay.getMonth() + 1)).slice(-2) + '/' + firstDay.getDate() + '/' + firstDay.getFullYear());
                  $("#end_date").val(("0" + (date.getMonth() + 1)).slice(-2) +'/' + date.getDate() + '/' + date.getFullYear());
                  $("#checkBtn").trigger("click");
              break;
       case 6:
                var firstDay = new Date(date.getFullYear(), date.getMonth()-1, 1);
                var lastDay = new Date(date.getFullYear(), date.getMonth(), 0);
                $("#start_date").val(("0" + (firstDay.getMonth() + 1)).slice(-2) + '/' + firstDay.getDate() + '/' + firstDay.getFullYear());
                $("#end_date").val(("0" + (lastDay.getMonth() + 1)).slice(-2) + '/' + lastDay.getDate() + '/' + lastDay.getFullYear());
                $("#checkBtn").trigger("click");
              break;
		case 7:
                var firstDay = new Date(date.getFullYear(),0);
                $("#start_date").val(("0" + (firstDay.getMonth() + 1)).slice(-2) + '/' + firstDay.getDate() + '/' + firstDay.getFullYear());
                $("#end_date").val(("0" + (date.getMonth() + 1)).slice(-2) +'/' + date.getDate() + '/' + date.getFullYear());
                $("#checkBtn").trigger("click");
              break;
      default:

    }
}

$(document).ready(function() {
    queryByDate(7);
});

//Date picker
var date = new Date();

date.setDate(date.getDate()-60);
$('#start_date').datepicker({
	autoclose: true,
	// startDate: date,
	// endDate: '+0d',
	dateFormat: 'dd/mm/yy'
});
$('#end_date').datepicker({
	autoclose: true,
	startDate: date,
	todayHighlight: true,
	endDate: '+0d',
	dateFormat: 'dd/mm/yy'
});
</script>
@endsection
