@extends('master')
@section('title')
    Create Attendance
@endsection
@section('custom_link_css')
<!-- Select 2 -->
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload Kunjungan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Upload Kunjungan</a></li>
              <li class="breadcrumb-item active">Buat Upload Kunjungan</li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">Foto</label>
                                <br>
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @if(session()->has('message'))
                                    <div class="alert alert-danger mt-2">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                <button id="open_cam" class="btn btn-md btn-info"><i class="fa fa-camera-retro"></i> Kamera</button>
                                <input type="file" id="upload" class="form-control image @error('image') is-invalid @enderror" name="image" capture="camera" required style="display: none;">
                            
                                <!-- error message untuk title -->
                                
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Nama RS</label>
                                <select id="outlet-dd" name="outlet_name" class="form-control" required>
                                    <option>Nama RS</option>
                                    @foreach ($outlets as $outlet)
                                    <option value="{{$outlet->id.'|'.$outlet->name}}">
                                        {{$outlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div><br>
                            @if (Auth::User()->department == 0 || Auth::User()->department == 1 || Auth::User()->department == 6)
                            <div class="form-group">
                                <label class="font-weight-bold">Nama User</label>
                                <select id="useroutlet-dd" name="useroutlet_name"  class="form-control" required>
                                    <option value="">Pilih User</option>
                                </select>
                            </div>
                            @endif
                            <br>

                            <div class="form-group">
                                <label class="font-weight-bold">Aktifitas</label>
                                <br>
                                <textarea id="activity" class=" appearance-none border rounded" rows="6" cols="110" style="max-width: 100%" name="activity" required></textarea> 
                            </div>
                            <br>

                            <input type='hidden' name='check' value='' id='check'>
                            <input type="hidden" name="tmp_lat" id="tmp_lat" value="">
                            <input type="hidden" name="tmp_lng" id="tmp_lng" value="">

                            <button type="submit" id="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
@section('custom_script_js')
<!-- Select 2 -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#check').val(screen.width);
        if (screen.width >= 450) {
            alert('Anda Harus Absen Menggunakan Handphone!');
            location.href = "{{ route('posts.index') }}"

        }

        $('#outlet-dd').select2({
                width:'100%',
                theme: 'bootstrap4',
        });
        
        $('#useroutlet-dd').select2({
            width:'100%',
            theme: 'bootstrap4',
        }); 
        var site_url = "{{ url('/') }}";
        $('#outlet-dd').on('change', function () {
            var idOutlet = this.value;
            $("#useroutlet-dd").html('');
            $.ajax({
                url: site_url + "/api/fetch-useroutlet",
                type: "POST",
                data: {
                    outlet_id: idOutlet,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    $('#useroutlet-dd').after('<input type="hidden" name="jabatan_name" value="'+result[0].jabatan+'|'+result[0].jabatan_name+'">');
                    $('#useroutlet-dd').html('<option value="">Pilih User</option>');
                    $.each(result, function( key, value ) {
                        let val = value.id + '|' + value.name
                        $("#useroutlet-dd").append('<option value="' + val + '">' + value.name + '</option>');
                    });
                }
            });
        });  
        $('#submit').click(function(){
            if(
                $('#upload').val() != '' &&
                $('#outlet-dd').val() != '' &&
                $('#useroutlet-dd').val() != '' &&
                $('#activity').val() != ''
            ){
                $('#loader').modal('show');
            }
            
        });

        // open camera
        $('#open_cam').on('click', function (e) {
            e.preventDefault();
            $('#upload').trigger('click');
        });

        ///////////// start for ios //////////////
        let tmp_route = "{{ route('posts.store') }}";
        const getMobileOS = () => {
          const ua = navigator.userAgent
          if (/android/i.test(ua)) {
            // return "Android" do nothing
          }
          else if ((/iPad|iPhone|iPod/.test(ua))
             || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)){
            // return "iOS"
            tmp_route = "{{ route('posts.storeios') }}";
          }
          // return "Other" do nothing
        }

        // default "global_code" : "6P58QRX4+9QW"
        let tmp_lat = '-6.2015179';
        let tmp_lng = '106.8069573';

        function getGPS() {
            if (navigator.geolocation) {  
                navigator.geolocation.getCurrentPosition(showGPS, gpsError);
            } else {  
                gpsText = "No GPS Functionality.";
                alert(gpsText);
            }
        }

        function gpsError(error) {
            alert("GPS Error: "+error.code+", "+error.message);
        }

        function showGPS(position) {
            gpsText = "Latitude: "+position.coords.latitude+"\nLongitude: "+position.coords.longitude;
            
            tmp_lat = position.coords.latitude;
            tmp_lng = position.coords.longitude;
        }

        $('form').attr('action',tmp_route);
        $('#tmp_lng').val(tmp_lng);
        $('#tmp_lat').val(tmp_lat);
        ///////////// end for ios //////////////

    });
</script>
@endsection