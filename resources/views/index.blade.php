@extends('master')
@section('title')
    Dashboard
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
                <img src="{{asset('assets/img/camera-icon.png')}}" style="width: 100%">
              </div>
              <a href="{{route('posts.create')}}" class="small-box-footer">
                New Attendance <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <img src="{{asset('assets/img/pngcalendar.png')}}" style="width: 100%">
              </div>
              <a href="{{route('event.index')}}" class="small-box-footer">
                Calendar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /.row -->
  	</div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection