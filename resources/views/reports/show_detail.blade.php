@extends('master')
@section('title')
    Details
@endsection
@section('custom_link_css')
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: linen">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Detail Laporan Absensi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('reports.absensi') }}"> Back To Laporan Absensi</a></li>
                            <li class="breadcrumb-item active">Detail Laporan Absensi</li>
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
                            <div class="card-body table-responsive p-0" style="height: 450px;">
                                <table class="table table-bordered no-margin">
                                    <thead>
                                        @foreach ($attendances as $attendance)
                                            @php
                                                $created_at = is_null($attendance->created_at) ? '-' : $attendance->created_at;
                                                
                                                $updated_at = is_null($attendance->updated_at) ? '-' : $attendance->updated_at;
                                            @endphp
                                            <tr>
                                                <th>NIK</th>
                                                <td>{{ $attendance->nik }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                <td>{{ $attendance->user_fullname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Hari</th>
                                                <td>{{ $attendance->hari }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <td>{{ date('d-m-Y', strtotime(explode(' ', $created_at)[0])) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{ $attendance->department }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jam Masuk</th>
                                                <td>{{ date('G:i:s', strtotime(explode('now', $created_at)[0])) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jam Pulang</th>
                                                <td>{{ date('G:i:s', strtotime(explode('now', $updated_at)[0])) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Jam Kerja</th>
                                                <td>{{ $attendance->work_hour }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telat</th>
                                                <td>{{ $attendance->late }}</td>
                                            </tr>
                                            <tr>
                                                <th>Foto</th>
                                                <td class="text-left">
                                                    <img src="{{ asset('/assets/img/clock_in_img/' . $attendance->clock_in_img) }}"
                                                        class="rounded" style="width: 250px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Peta/Lokasi</th>
                                                <td class="td_map_detail">
                                                    @php
                                                        $explode_loc = explode('|', $attendance->clock_in_loc);
                                                        $latitude = isset($explode_loc[0]) ? $explode_loc[0] : 0;
                                                        $longitude = isset($explode_loc[1]) ? $explode_loc[1] : 0;
                                                    @endphp

                                                    <iframe width="250" height="250" frameborder="0" scrolling="no"
                                                        marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?width=400&amp;height=400&amp;hl=en&amp;q={{ $latitude }},{{ $longitude }}+({{ $attendance->user_fullname }})&amp;t=k&amp;z=19&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                                                    </iframe>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        </div>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
@endsection
