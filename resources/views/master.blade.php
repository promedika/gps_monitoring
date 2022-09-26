<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | GPS Monitoring</title>

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
<body class="hold-tr(ansition sidebar-mini layout-fixed">
  <div class="modal fade in" id="loader" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: transparent; box-shadow: none; border: none;">
        <div class="modal-body" style="left: 25%">
          <img src="{{asset('/assets/img/gps-loader.gif')}}" style="width:50%; height:100%;">
        </div>
      </div>
    </div>
  </div>
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

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img src="{{asset('assets/img/pngwing.com.png')}}" class="img-circle elevation-2" style="width:30px; height:30px" alt="User Image">
          <span><b>{{Auth::User()->first_name." ".Auth::User()->last_name}}</b></span>
        </a>
        <div class="dropdown-menu dropdown-menu-md">
          <a href="#" user-id="{{Auth::User()->id}}" class="dropdown-item btn-edit-user-master-password" style="text-align: center"><i class="fas fa-cog"> Ubah Password</i></a>
            <!-- Message End -->
          <a href="{{route('logout')}}" user-id="{{Auth::User()->id}}" class="dropdown-item btn-logout" style="text-align: left"><i class="fas fa-door-open"> Logout</i></a>
        </div>
      </li>
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
      <span class="brand-text font-weight-light"><strong>Monitoring</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
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

          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (Auth::user()->role !=1)
              <li class="nav-item">
                <a href="{{route('dashboard.users.index')}}" class="nav-link" style="color: #343a40;">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                    P.I.C
                    </p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{route('outlet.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fa fa-building"></i>
                    Tenant
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('useroutlet.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fa fa-user"></i></i>
                    User Tenant
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('jabatan.index')}}" class="nav-link" style="color: #343a40;">
                  <p>
                    <i class="nav-icon fa fa-user-tie"></i></i>
                    Jabatan User
                  </p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="{{route('posts.index')}}" class="nav-link">
              <p>
                <i class="nav-icon fas fa-image"></i>
                Riwayat Kunjungan
              </p>
            </a>
          </li>
          @if (Auth::user()->role !=1)
          <li class="nav-item">
            <a href="{{route('reports.index')}}" class="nav-link" style="color: #343a40;">
              <p>
                <i class="nav-icon fas fa-book-open"></i>
                Laporan Absensi
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item"">
            <a href="{{route('dashboard.attendances.index')}}" class="nav-link">
              <p>
                <i class="nav-icon fas fa-clock"></i>
                Riwayat Absensi
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

<!-- Modal Edit User -->
<div class="modal fade in" id="modalEditUserPassword" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-edit-master-password">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ubah Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="first_name" type="text" name="first_name">{{Auth::User()->first_name}} {{Auth::User()->last_name}}</label>
        </div>
        <div class="form-group">
          <label for="password">Password <span style="font-size: 10px; color:red">*Kosongkan jika tidak ingin merubah password</span></label>
          <input placeholder="Kosongkan jika tidak ingin merubah password" type="master_password" name="master_password" id="master_password_update" class="form-control">
          <span id="errorPassword" class="text-red"></span>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>

<script>
  $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          }
      });

      jQuery("body").on("click", ".btn-edit-user-master-password", function(e) {
            $('#modalEditUserPassword').modal('show');
            var userID = $(this).attr('user-id');
            var id = $('#id').val(userID);
                $.ajax({
                    url:"{{route('dashboard.users.editpassword')}}",
                    type:'POST',
                    data:{
                      id:userID,
                    },
                    success:function(data){
                        console.log('success edit');
                        $('#master_password_update').val(data.data.password);;
                    },
                    error:function(response){
                        $('#errorPassword').text(response.responseJSON.errors.password);
                    }
                    
                })

                $('#form-edit-master-password').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalEditUserPassword');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('dashboard.users.updatepassword')}}",
                    type:'POST',
                    data:formData,
                    data:{
                      id:userID,
                      password:$('#master_password_update').val(),
                    },
                    beforeSend: function() {
                      modal_id.find('.modal-footer button').prop('disabled',true);
                      modal_id.find('.modal-header button').prop('disabled',true);
                    },
                    success:function(data){
                        console.log('success update');
                        location.reload();
                    },
                    error:function(response){
                        $('#errorPassword').text(response.responseJSON.errors.password);

                        modal_id.find('.modal-footer button').prop('disabled',false);
                        modal_id.find('.modal-header button').prop('disabled',false);
                    }
                })
            })
        })

      })
</script>

@yield('custom_script_js')
</body>
</html>
