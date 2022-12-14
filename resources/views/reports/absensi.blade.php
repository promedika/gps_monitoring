@extends('master')
@section('title')
    Reports
@endsection
@section('custom_link_css')
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: linen">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Laporan Absensi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Laporan Absensi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                    <div>
                      <form action="{{route('reports.absensi.filter')}}" method="post" accept-charset="utf-8" id="show-monthly-report">

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
                                            <th scope="col">NIK</th>
                                            <th scope="col">Nama Karyawan</th>
                                            <th scope="col">Hari</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Jam Masuk</th>
                                            <th scope="col">Jam Pulang</th>
                                            <th scope="col">Total Jam Kerja</th>
                                            <th scope="col">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($attendances as $attendance)
                                            <tr class="data_post">
                                                @php
                                                    $created_at = is_null($attendance->created_at) ? '-' : $attendance->created_at;
                                                    
                                                    $updated_at = is_null($attendance->updated_at) ? '-' : $attendance->updated_at;
                                                @endphp
                                                <td>{{ $attendance->nik }}</td>
                                                <td>{{ $attendance->user_fullname }}</td>
                                                <td>{{ $attendance->hari }}</td>
                                                <td>{{ date('d-m-Y', strtotime(explode(' ', $created_at)[0])) }}</td>
                                                <td>{{ $attendance->department }}</td>
                                                <td>{{ date('G:i:s', strtotime(explode('now', $created_at)[0])) }}</td>
                                                <td>{{ date('G:i:s', strtotime(explode('now', $updated_at)[0])) }}</td>
                                                <td>{{ $attendance->work_hour }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('reports.show_detail')}}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <input type='hidden' name='id' value='{{$attendance->id}}'>
                                                        <button type='submit' class="btn btn-info modalMd" title=""
                                                            data-toggle="modal" data-target="#modalMd"><span
                                                                class="fas fa-eye"></span></a>
                                                        </button>
                                                    </form>
                                                </td>
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
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{asset('assets/AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        //message with toastr
        @if (session()->has('success'))

            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>

    <script>
        jQuery(document).ready(function() {
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

            $('.modalMd').off('click').on('click', function() {
                $('#modalMdContent').load($(this).attr('value'));
                $('#modalMdTitle').html($(this).attr('title'));
            });

            $("#table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [ 
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                ]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            $('title').text('Laporan Absensi');

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
