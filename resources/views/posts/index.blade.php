@extends('master')
@section('title')
    Image Attendance
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
            <h1>Image Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Image Attendance</li>
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
                        <a href="{{ route('posts.create') }}" class="btn btn-md btn-primary mb-3">New Attendance</a>
                        <table class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">User</th>
                                <th scope="col">Image</th>
                                <th scope="col">Location</th>
                                <th scope="col">P.I.C</th>
                                <th scope="col">Image Taken</th>
                                <th scope="col">Location Based on Image</th>
                                {{-- <th scope="col">Action</th> --}}
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                     ?>
                              @forelse ($posts as $post)
                                <tr class="data_post">
                                    <td>{{$nomor++}}</td>
                                    <td>{{ $post->user_fullname}}</td>  
                                    <td class="text-center">
                                        <!-- <img src="{{Storage::url('posts/').$post->image }}" class="rounded" style="width: 150px"> -->
                                        <img src="{{ asset('/storage/posts/'.$post->image) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $post->outlet_name }}</td>
                                    <td>{!! $post->outlet_user !!}</td>
                                    <td>
                                        @php
                                            $imgTaken = is_null($post->imgTaken) ? '-' : $post->imgTaken;
                                        @endphp
                                        {{$imgTaken}}
                                    </td>
                                    <td class="td_map_detail">
                                        @php
                                            $explode_loc = explode('|',$post->imgLoc);
                                            $latitude = isset($explode_loc[0]) ? $explode_loc[0] : 0;
                                            $longitude = isset($explode_loc[1]) ? $explode_loc[1] : 0;
                                        @endphp
                                        <div class="map" data-latitude="{{$latitude}}" data-longitude="{{$longitude}}">{{$post->imgLoc}}</div>
                                    </td>
                                    {{-- <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td> --}}
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
            $('.table').DataTable();

            jQuery('.data_post').each(function(index, value) {
                let td_map = jQuery(this).find('.map');
                let latitude = td_map.data('latitude');
                let longitude = td_map.data('longitude');
                console.log(latitude+'|'+longitude);

                var myCenter = new google.maps.LatLng(latitude, longitude);
                function initialize()
                {
                    var mapProp = 
                    {
                        center:myCenter,
                        zoom:19,
                        mapTypeId:google.maps.MapTypeId.ROADMAP
                    };

                    // var map = new google.maps.Map(document.getElementById("map"),mapProp);
                    let map = new google.maps.Map(td_map,mapProp);

                    var marker = new google.maps.Marker({
                        position:myCenter,
                        animation:google.maps.Animation.BOUNCE
                    });

                    marker.setMap(map);
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            });

        });
</script>
@endsection