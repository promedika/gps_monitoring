<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | GPS Monitoring</title>

  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('/assets/img/favicon.ico')}}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{route('login')}}" class="h1"><b>Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{route('action.login')}}" method="post">
        @csrf
        @if(session()->has('message'))
          <div class="alert alert-danger mt-2">
            {{ session()->get('message') }}
          </div>
        @endif
        <div class="input-group mb-3">
          <input class="form-control" placeholder="Masukan Nomor Handphone" type="number" name="phone" required>
          @if ($errors->has('phone'))
 
          <span class="text-danger">{{ $errors->first('phone') }}</span>

      @endif
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input class="form-control" placeholder="Masukan Password" type="password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            &nbsp;
          </div>
          <!-- /.col -->
          <div class="col-4">
            {{-- <input type='hidden' name='check' value='' id='check'> --}}
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>

<script>
  $(document).ready(function() {
    //   var site_url = "{{ url('/') }}";
    // $('#check').val(screen.width)
      // if (screen.width >= 450) {
      //     alert('Anda Harus Absen Menggunakan Handphone !')
      //  return false;

      // }
    });
    </script>
</body>
</html>