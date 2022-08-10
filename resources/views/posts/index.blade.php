@extends('master')
@section('title')
    Image Attendance
@endsection
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | GPS HRMS</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUOzfEMYXPD8rEgJpJEbBFxhJ9GuBS0-8"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mb-5">
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('posts.create') }}" class="btn btn-md btn-primary mb-3">New Attendance</a>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">User</th>
                                <th scope="col">Image</th>
                                <th scope="col">Location</th>
                                <th scope="col">P.I.C</th>
                                <th scope="col">Image Taken</th>
                                <th scope="col">Location Based on Image</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($posts as $post)
                                <tr class="data_post">
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
                                            $latitude = isset($explode_loc[0]) ? 0 : $explode_loc[0];
                                            $longitude = isset($explode_loc[1]) ? 0 : $explode_loc[1];
                                        @endphp
                                        <div class="map" data-latitude="{{$latitude}}" data-longitude="{{$longitude}}"></div>
                                    </td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data Post belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{ $posts->links() }}
                    </div>
                </div>
            </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUOzfEMYXPD8rEgJpJEbBFxhJ9GuBS0-8"></script>

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

</body>
</html>
@endsection