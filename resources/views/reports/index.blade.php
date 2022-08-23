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
                    <div class="card-body">
                        <table class="table" id="report">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">User</th>
                                <th scope="col">Date</th>
                                <th scope="col">Work Hours</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                     ?>
                              @forelse ($posts as $post)
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
                              @empty
                                  <div class="alert alert-danger">
                                      Data Post belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{-- {{ $posts->links() }} --}}
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="modal fade in" id="modalShow">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div>
                <h2 class="work_hour"></h2>
                <h2 class="status"></h2>
            </div>
            <table class="table table-bordered table-hover" id="post-table">
                <thead>
                  <tr>
                    <th scope="col">User</th>
                    <th scope="col">Location</th>
                    <th scope="col">P.I.C</th>
                    <th scope="col">Image Taken</th>
                    {{-- <th scope="col">Action</th> --}}
                  </tr>
                </thead>
            </table> 
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
            "autoWidth": false,
            "responsive": true,
            });

            $('.btn-detail').click(function(){
            $('#modalShow').find('.modal-title').text($(this).data("fullname")+","+$(this).data("date")) 
            $('#modalShow').find('.work_hour').text($(this).data('work_hour'));
            $('#modalShow').find('.status').text($(this).data('status'));
            $('#modalShow').modal('show');
            var postID = $(this).data('post_id');
                $.ajax({
                    url:"{{route('reports.show')}}",
                    data:{
                        id:postID,
                    },
                    beforeSend: function() {
                        jQuery('#post-table').DataTable().destroy();
                        jQuery('#post-table tbody').remove();
                    },
                    success:function(data){
                        console.log('success show');
                        console.log(data);
                        var table_log = '<tbody>';
                            // table_log += '<tbody>'+
                            jQuery.each(data, function(key,value) {
                                table_log += '<tr>'+
                                    '<td>'+value.user_fullname+'</td>'+
                                    '<td>'+value.outlet_name+'</td>'+
                                    '<td>'+value.outlet_user+'</td>'+
                                    '<td>'+value.imgTaken+'</td>'+
                                '</tr>';
                            });
                            table_log += '</tbody>';
                            console.log(table_log);
                            $('#post-table').find('thead').after(table_log);

                            $('#post-table').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            });
                            



                    }
                })
            
            });

        });
    </script>
@endsection