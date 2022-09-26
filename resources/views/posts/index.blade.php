@extends('master')
@section('title')
    Marketing Attendance
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
            <h1>Riwayat Kunjungan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Riwayat Kunjungan</li>
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
                    <div class="card-header">
                      <a href="{{ route('posts.create') }}" title="Add" class="btn btn-primary btn-block col-2 btn-add-user"><i class="fa solid fa-plus"></i></a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="table">
                            <thead>
                              <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">P.I.C</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">User</th>
                                <th scope="col">jabatan</th>
                                <th scope="col">Aktifitas</th>
                                <th scope="col">Peta</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                     ?>
                              @foreach ($posts as $post)
                                <tr class="data_post">
                                  <td>
                                    @php
                                        $imgTaken = is_null($post->imgTaken) ? '-' : $post->imgTaken;
                                    @endphp
                                    {{$imgTaken}}
                                </td>
                                    <td>{{ $post->user_fullname}}</td>  
                                    <td class="text-center">
                                        <img src="{{ asset('/storage/posts/'.$post->image) }}" class="rounded" style="width: 200px">
                                    </td>
                                    <td>{{ $post->outlet_name }}</td>
                                    <td>{!! $post->outlet_user !!}</td>
                                    <td>{{$post->jabatan_name}}</td>
                                    <td>{{$post->activity}}</td>
                                    <td class="td_map_detail">
                                        @php
                                            $explode_loc = explode('|',$post->imgLoc);
                                            $latitude = isset($explode_loc[0]) ? $explode_loc[0] : 0;
                                            $longitude = isset($explode_loc[1]) ? $explode_loc[1] : 0;
                                        @endphp

                                        <iframe 
                                            width="200" 
                                            height="200" 
                                            frameborder="0" 
                                            scrolling="no" 
                                            marginheight="0" 
                                            marginwidth="0" 
                                            src="https://maps.google.com/maps?width=400&amp;height=400&amp;hl=en&amp;q={{$latitude}},{{$longitude}}+({{$post->user_fullname}})&amp;t=k&amp;z=19&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                                        </iframe>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>  
                          {{-- {{ $posts->links() }} --}}
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
            $('#table').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
            });
        });
</script>
@endsection