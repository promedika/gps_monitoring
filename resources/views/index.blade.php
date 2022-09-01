@extends('master')
@section('title')
    Dashboard
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background: linen;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Home</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
  	<div class="container-fluid">
  		<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <a href="#" id="newatt" title="newatt" style="color:white"><img src="{{asset('assets/img/camera-icon.png')}}" style="width: 100%">New Attendance</a>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <a href="{{route('event.index')}}" style="color:white"><img src="{{asset('assets/img/pngcalendar.png')}}" style="width: 100%">Calendar</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
  	</div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<div class="modal fade in" id="modalCreateNewAtt" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      {{-- <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-newatt"> --}}
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Attendance</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <button for="clockin">Clock In</button>
          <input type="file" name="clock_in_img" id="clock_in_img" class="form-control" style="display:none">
          <span id="errorName" class="text-red"></span>
        </div>

        <div class="form-group">
          <a href="{{route('posts.create')}}"><button for="visit">Visit</button></a>
          <span id="errorName" class="text-red"></span>
        </div>

        <div class="form-group">
          <button for="clockin">Clock Out</button>
          <input type="file" name="clock_out_img" id="clock_out_img" class="form-control" style="display:none">
          <span id="errorName" class="text-red"></span>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('custom_script_js')
<script>
  $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('#newatt').click(function(){
          $('#modalCreateNewAtt').modal('show');
      })
    })
</script>
@endsection