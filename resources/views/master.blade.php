<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | GPS HRMS</title>

  <meta name="csrf-token" content="{{csrf_token()}}"/>

  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('/assets/img/favicon.ico')}}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">
  <!-- csrf -->
  <meta name="csrf-token" content="{{csrf_token()}}"/>

  @yield('custom_link_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" style>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" style="background: linen;">
    <!-- Brand Logo -->
    <a href="{{route('dashboard.index')}}" class="brand-link" style="text-align: center">
      <img src="{{asset('assets/img/logogpstext.png')}}" alt="GPS Logo" class="brand-image" style="margin-left: -5px; margin-right: 0; max-height: 50px; margin-top: -0.5rem;">
      <span class="brand-text font-weight-light"><strong>HRMS</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/img/pngwing.com.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::User()->first_name}} {{Auth::User()->last_name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="height: ">
          <li class="nav-item">
            <a href="{{route('dashboard.index')}}" class="nav-link">
              <p>
                <i class="nav-icon fa fa-laptop"></i>
                Dashboard
              </p>
            </a>
          </li>

          @if (Auth::user()->role !=1)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('dashboard.users.index')}}" class="nav-link" style="color: #343a40;">
                  
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                    Users
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('outlet.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fa fa-building"></i>
                    Outlet
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('useroutlet.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fa fa-user"></i></i>
                    User Outlet
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('reports.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fas fa-book-open"></i>
                    Attendance Reports
                  </p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{route('event.index')}}" class="nav-link">
              <p>
                <i class="nav-icon fas fa-calendar"></i>
                Calendar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('posts.index')}}" class="nav-link">
              <p>
                <i class="nav-icon fas fa-image"></i>
                Image Attendance
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
              <p>
                <i class="nav-icon fas fa-door-open"></i>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper" style="background: linen;">
    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      &nbsp;
    </div>
    <!-- Default to the left -->
    <strong>PT Global promedika Service - All rights reserved - Copyright &copy; {{date('Y')}}</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>

@yield('custom_script_js')
</body>
</html>
