@extends('master')
@section('title')
    Image Attendance
@endsection
@section('content')

    <div class="container mb-5">
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table cellspacing="5" cellpadding="5" border="0">
                            <tbody><tr>
                                <td>Start date:</td>
                                <td><input type="text" id="min" name="min"></td>
                            </tr>
                            <tr>
                                <td>End date:</td>
                                <td><input type="text" id="max" name="max"></td>
                            </tr>
                        </tbody></table>
                        <table class="table-bordered">
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
                          {{-- {{ $posts->links() }} --}}
                    </div>
                </div>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>  
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>  
    <script type="text/javascript">
            var minDate, maxDate;
    
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date( data[4] );
    
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
    );
    
    $(document).ready(function() {
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });
    
        // DataTables initialisation
        var table = $('.table-bordered  ').DataTable();
    
        // Refilter the table
        $('#min, #max').on('change', function () {
            table.draw();
        });
    });
    </script>
    {{-- <script>
        jQuery(document).ready(function () {
            $('.table-bordered').DataTable();

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
</script> --}}
@endsection