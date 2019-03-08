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
                        <h4 class="modal-title" id="myModalLabel">New Athlete</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="userForm" role="form" action="{{url('admin/city/new')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('state_name') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="state_name">State Name <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="state_name" name="state_name" placeholder="State Name" value="{{old('state_name')}}"/>
                                    @if ($errors->has('state_name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('city_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="country">Country <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <select name="country" id="country" class="form-control">
                                        <option selected disabled>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <select name="state" id="state" class="form-control"></select>
                                    @if ($errors->has('state'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('state') }}</strong>
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
                            <table id="example1" class="table table-bordered table-striped">
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

        $(function() {
            $('#example1').DataTable({
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

        $('#country').on('change', function() {
            var country_id = $('#country').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type :'POST',
                data : {
                    id:country_id
                },
                url  : SITE_URL+'/getState',
                success  : function(response) {
                    $('#state').html(response);
                }
            });
        });

    </script>
@endsection
