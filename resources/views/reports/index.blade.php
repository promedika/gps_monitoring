@extends('master')
@section('title')
    Image Attendance
@endsection
@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
@endsection
@section('content')
<div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Attendance Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Attendance Reports</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap border" id="reports">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                @foreach ($data[0] as $value)
                                <th scope="col">{{str_replace('day_','',$value)}}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @if (count($data) == 1)
                                <tr class="visit">
                                    <td colspan="{{count($data[0]+1)}}">
                                      <div class="alert alert-danger">
                                          <h6 align="center"> Data post Belum Tersedia</h6>
                                      </div>
                                    </td>
                                </tr>
                                @else
                                <?php /*
                                @php $nomor = 1; @endphp
                                @foreach ($data as $key => $value)
                                    @php if ($key == 0) continue; @endphp
                                    <tr class="data_post">
                                        <td>{{$nomor++}}</td>
                                        <td>{{$post->user_fullname}}</td>
                                        <td>{{str_replace(' 00:00:00','',$post->created_at)}}</td>
                                        <td>{{$post->work_hour}}</td>
                                        <td>{{$post->status}}</td>
                                        <td class="text-center">
                                                <a href="#" data-post_id="{{$post->id}}" class="btn bg-warning btn-detail" data-work_hour="{{$post->work_hour}}" data-status="{{$post->status}}" data-fullname="{{$post->user_fullname}}" data-date="{{str_replace(' 00:00:00','',$post->created_at)}}">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                */ ?>
                                @endif
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
@section('custom_script_js')
    <!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.12.1/filtering/row-based/range_dates.js"></script>
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
    $(document).ready(function(){
        $('#report').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "scrollY": true,
        });
    });
</script>
@endsection