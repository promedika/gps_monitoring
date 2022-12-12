@extends('master')
@section('title')
    Reports
@endsection
@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Kunjungan Marketing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Kunjungan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="table">
                            <thead>
                              <tr>
                                <th scope="col">Hari</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Jam</th>
                                <th scope="col">P.I.C</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">User RS</th>
                                <th scope="col">Jabatan User RS</th>
                                <th scope="col">Aktifitas</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                     ?>
                                @foreach ($posts as $post)
                                <tr class="data_post">
                                    @php
                                        $imgTaken = is_null($post->imgTaken) ? '-' : $post->imgTaken;
                                    @endphp
                                    <td>{{ $post->hari }}</td>
                                    <td>{{date('d-m-Y',strtotime(explode(' ',$imgTaken)[0]))}}</td>
                                    <td>{{date('F Y',strtotime(explode(' ',$imgTaken)[0]))}}</td>
                                    <td>{{date('h:i:s',strtotime(explode(' ',$imgTaken)[0]))}}</td>

                                    <td>{{ $post->user_fullname}}</td>
                                    <td>{{ $post->outlet_name }}</td>
                                    <td>{!! $post->outlet_user !!}</td>
                                    <td>{{$post->jabatan_name}}</td>
                                    <td>{{$post->activity}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table> 
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('custom_script_js')
<!-- DataTables  & Plugins -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>     
<script>
    //message with toastr
    @if(session()->has('success'))
    
        toastr.success('{{ session('success') }}', 'BERHASIL!'); 

    @elseif(session()->has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!'); 
        
    @endif
</script>

<script>
  jQuery(document).ready(function () {
    // $('#table').DataTable({
    //   "paging": true,
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    //   "order": [[0, 'desc']],
    // });

    $("#table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('title').text('Laporan Kunjungan Marketing');
  });
</script>
@endsection