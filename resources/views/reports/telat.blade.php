@extends('master')
@section('title')
    Reports
@endsection
@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper" style="background: linen">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Keterlambatan Absensi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
            <li class="breadcrumb-item active">Laporan Keterlambatan Absensi</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div>
              <form action="{{route('reports.filter')}}" method="post" accept-charset="utf-8" id="show-monthly-report">

                @csrf
                
                <div class="card-header" style="display: flex">
                  <div class="col-2 form-group">
                    <div class="input-group date" id="first_date" data-target-input="nearest">
                      <input value="{{(is_null(Session::get('first_date'))) ? "Pilih Bulan Awal" : Session::get('first_date')}}" name="first_date" placeholder="Pilih Bulan & Tahun" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#first_date" readonly required/>
                    </div>
                  </div>

                  <div class="col-2 form-group">
                    <div class="input-group date" id="end_date" data-target-input="nearest">
                      <input value="{{(is_null(Session::get('end_date'))) ? "Pilih Bulan Akhir" : Session::get('end_date')}}" name="end_date" placeholder="Pilih Bulan & Tahun" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#end_date" readonly required/>
                    </div>
                  </div>

                  <div>
                     <input type="submit" value="Submit" class="btn btn-primary">
                  </div>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
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
                                <th scope="col">No</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Nama Karyawan</th>
                                <th scope="col">Department</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Terlambat</th>
                                <th scope="col">Tidak clock in/out</th>
                                <th scope="col">Tidak Clock In</th>
                                <th scope="col">Tidak Clock Out</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Nilai Denda</th>
                                <th scope="col">Jumlah Potongan</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                              @foreach ($custom_att as $custom)
                              <tr class="data_post">
                              <td>{{$custom['no']}}</td>
                              <td>{{$custom['nik']}}</td>
                              <td>{{$custom['nama_karyawan']}}</td>
                              <td>{{$custom['departemen']}}</td>
                              <td>{{$custom['bulan']}}</td>
                              <td>{{$custom['late']}}</td>
                              <td>{{$custom['not_in_out']}}</td>
                              <td>{{$custom['not_in']}}</td>
                              <td>{{$custom['not_out']}}</td>
                              <td>{{$custom['jumlah']}}</td> 
                              <td>{{$custom['denda']}}</td>
                              <td>{{$custom['potongan']}}</td>
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
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
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

    $('title').text('Laporan Keterlambatan Absensi');

    //Date picker
    $('#first_date').datetimepicker({
        // viewMode: 'months', 
        format: 'YYYY-MM-DD'
    });
    //Date picker
    $('#end_date').datetimepicker({
        // viewMode: 'months', 
        format: 'YYYY-MM-DD'
    });
  });
</script>

@endsection