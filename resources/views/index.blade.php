@extends('master')
@section('title')
    Dashboard
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: linen;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Beranda</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        @if (Auth::User()->department == 6)
        <section class="content">

            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">GPS Monitoring</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                Welcome to GPS Monitoring System, this system for marketing attendance, monitoring target sales and marketing report.
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        @endif
        <!-- /.content -->

        <!-- Main content -->
        @if (Auth::User()->department == 6)
        @else
        <section class="content">
            <div class="container-fluid">
                @if(session()->has('success'))
                <div class="alert alert-success mt-2">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <a href="#" id="newatt" title="newatt" style="color:white"><img
                                        src="{{ asset('assets/img/camera-icon.png') }}" style="width: 100%;">Absensi</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        @if (Auth::User()->department == 0 || Auth::User()->department == 1)
                            <div class="small-box" style="background-color:lightsalmon">
                                <div class="inner">
                                    <a href="#" id="riwayat" title="riwayat" style="color:white"><img
                                            src="{{ asset('assets/img/pngcalendar.png') }}" style="width: 100%;">Riwayat</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        @endif
        <!-- /.content -->
    </div>
    @if (Auth::User()->department == 0 || Auth::User()->department == 1)
        <div class="modal fade in" id="modalCreateNewAtt">
            <div class="modal-header" style="background-color:#17a2b8;border-bottom:none;width:100%">
                <h4 class="modal-title" style="text-align: center;margin-left:40%;color:white">Absensi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="font-size:2.3rem" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-dialog   modal-fullscreen">
                <div class="modal-content"
                    style="background-color: transparent !important;
          border: 0px !important;box-shadow:none;">
                    <!-- Modal body -->
                    <div class="form-group" style="align-content: center;justify-content:center;">
                        <div>
                            <button
                                style="display:inline-block;
          margin-left: 25%;
          margin-top:10%;
          height: 200px;
          width: 200px;
          border-radius: 50%;"
                                for="clockin" class="btn btn-md btn-primary" id="clock_in_btn">
                                <img src="{{ asset('/assets/img/clock_in.png') }}" style="width: 80%">
                                Clock In
                            </button>
                            <input type="file" name="clock_in_img" id="clock_in_img" class="form-control"
                                style="display:none" accept="image/*" capture="camera">
                        </div>
                        <div>
                            <a href="{{ route('posts.create') }}">
                                <button
                                    style="display:inline-block;
            margin-left: 25%;
            margin-top:15%;
            height: 200px;
            width: 200px;
            border-radius: 50%;"
                                    for="visit" class="btn btn-md btn-success" id="visit_btn"><img
                                        src="{{ asset('assets/img/location.png') }}" style="width:100%">
                                    Visit
                                </button></a>
                        </div>
                        <div>
                            <button
                                style="display:inline-block;
            margin-left: 25%;
            margin-top:15%;
            height: 200px;
            width: 200px;
            border-radius: 50%;"
                                for="clockin" id="clock_out_btn" class="btn btn-md btn-primary"><img
                                    src="{{ asset('assets/img/clock_out.png') }}" style="width:80%">
                                Clock Out
                            </button>
                            <input type="file" name="clock_out_img" id="clock_out_img" class="form-control"
                                style="display:none" accept="image/*" capture="camera">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Modal Riwayat -->
        <div class="modal fade in" id="modalRiwayat">
            <div class="modal-header" style="background-color:lightsalmon;border-bottom:none">
                <h4 class="modal-title" style="text-align: center;margin-left:40%;color:white">Riwayat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="font-size:2.3rem" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content"
                    style="background-color: transparent !important;
          border: 0px !important;box-shadow:none;margin-top:10%">
                    <!-- Modal body -->
                    <div class="form-group" style="align-content: center;justify-content:center;">
                        <div>
                            <a href="{{ route('posts.index') }}">
                                <button
                                    style="display:inline-block;
            margin-left: 25%;
            height: 200px;
            width: 200px;
            background-color:rgb(233, 162, 38);
            border-radius: 50%;
            color:white;"
                                    for="post_btn" class="btn  btn-md" id="post_btn"><img
                                        src="{{ asset('assets/img/riwayat_kunjungan.png') }}" style="width:100%">
                                    Kunjungan
                                </button></a>
                            <a href="{{ route('dashboard.attendances.index') }}">
                                <button
                                    style="display:inline-block;
          margin-left: 25%;
          margin-top:15%;
          height: 200px;
          width: 200px;
          border:none;
            border-radius: 50%;
            background-color:teal;
            color:white;"
                                    for="att_btn" class="btn btn-md btn-success" id="att_btn"><img
                                        src="{{ asset('assets/img/riwayat_absensi.png') }}" style="width:80%">
                                    Absensi
                                </button></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    @endif
    @if (Auth::User()->department == 2 ||
        Auth::User()->department == 3 ||
        Auth::User()->department == 4 ||
        Auth::User()->department == 5)
        <div class="modal fade in" id="modalCreateNewAtt">
            <div class="modal-header" style="background-color:#17a2b8;border-bottom:none;width:100%">
                <h4 class="modal-title" style="text-align: center;margin-left:40%;color:white">Absensi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="font-size:2.3rem" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-dialog   modal-fullscreen">
                <div class="modal-content"
                    style="background-color: transparent !important;
          border: 0px !important;box-shadow:none;">
                    <!-- Modal body -->
                    <div class="form-group" style="align-content: center;justify-content:center;">
                        <div>
                            <a href="{{ route('attendances.createin') }}">
                                <button
                                    style="display:inline-block;
  margin-left: 25%;
  margin-top:15%;
  height: 200px;
  width: 200px;
  border-radius: 50%;"
                                    for="visit" class="btn btn-md btn-primary" id="visit_btn"><img
                                        src="{{ asset('assets/img/location.png') }}" style="width:100%">
                                    Clock In
                                </button></a>
                        </div>
                        <div>
                            <a href="{{ route('attendances.createout') }}">
                                <button
                                    style="display:inline-block;
    margin-left: 25%;
    margin-top:15%;
    height: 200px;
    width: 200px;
    border-radius: 50%;"
                                    for="visit" class="btn btn-md btn-success" id="visit_btn"><img
                                        src="{{ asset('assets/img/location.png') }}" style="width:100%">
                                    Clock Out
                                </button></a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('custom_script_js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let modal_create = $('#modalCreateNewAtt');

            $('#newatt').click(function() {
                if (screen.width >= 450) {
                    alert('Anda Harus Absen Menggunakan Handphone!')
                    return false;
                }
                else {
                    modal_create.modal('show');
                }
            })

            let modal_riwayat = $('#modalRiwayat');

            $('#riwayat').click(function() {
                modal_riwayat.modal('show');
            })

            // clock in
            modal_create.find('#clock_in_btn').on('click', function(e) {
                e.preventDefault();
                modal_create.find('#clock_in_img').trigger('click');
                submit_att('clock_in_img');
            });

            // clock out
            modal_create.find('#clock_out_btn').on('click', function(e) {
                e.preventDefault();
                modal_create.find('#clock_out_img').trigger('click');
                submit_att('clock_out_img');
            });

            ///////////// start for ios //////////////
            let tmp_route = "{{ route('attendances.upload') }}";
            const getMobileOS = () => {
              const ua = navigator.userAgent
              if (/android/i.test(ua)) {
                // return "Android" do nothing
                alert('android');
              }
              else if ((/iPad|iPhone|iPod/.test(ua))
                 || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)){
                // return "iOS"
                tmp_route = "{{ route('attendances.uploads') }}";
                alert('ios');
              }
              else {
                alert('windows or etc');
              }
            }

            function iOS() {
                return [
                    'iPad Simulator',
                    'iPhone Simulator',
                    'iPod Simulator',
                    'iPad',
                    'iPhone',
                    'iPod'
                ].includes(navigator.platform)
                // iPad on iOS 13 detection
                || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
            }

            let check_ios = iOS();
            if (check_ios) {
                tmp_route = "{{ route('attendances.uploads') }}";
            }

            getMobileOS();
            alert(check_ios);
            alert(tmp_route);

            // default "global_code" : "6P58QRX4+9QW"
            let tmp_lat = '-6.2015179';
            let tmp_lng = '106.8069573';

            $('body').data('tmplat',tmp_lat);
            $('body').data('tmplng',tmp_lng);

            tmp_lat = $('body').data('tmplat');
            tmp_lng = $('body').data('tmplng');

            alert('lat-def : '+tmp_lat+' | lng-def : '+tmp_lng);

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
                $('body').data('tmplat',tmp_lat);
                $('body').data('tmplng',tmp_lng);
                alert(gpsText);
                alert('lat-fix : '+tmp_lat+' | lng-fix : '+tmp_lng);
            }
            //////////// end for ios ///////////////
            getGPS();

            

            function submit_att(type_att) {
                let message_att = type_att == 'clock_in_img' ? 'clock in' : 'clock out';

                modal_create.find('#' + type_att).on('change', function(e) {
                    e.preventDefault();

                    // validate image
                    let validate = validate_img('' + type_att);

                    if (validate) {
                        var file_data = jQuery(this).prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('file', file_data);
                        form_data.append('type', type_att);
                        form_data.append('check', screen.width);

                        form_data.append('tmp_lat', tmp_lat);
                        form_data.append('tmp_lng', tmp_lng);

                        $.ajax({
                            type: 'POST',
                            url: tmp_route,
                            data: form_data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#loader').modal('show');
                                modal_create.find('#clock_in_img').prop('disabled', true);
                                modal_create.find('#clock_out_img').prop('disabled', true);
                                modal_create.find('#visit_btn').prop('disabled', true);
                                modal_create.modal('hide');
                            },
                            success: (data) => {
                                alert(data);
                                location.reload();
                            },
                            error: function(data) {
                                alert(data);
                                location.reload();
                            }
                        });
                    }
                });
            }

            // validate file image
            function validate_img(attr_name) {
                let message = attr_name == 'clock_in_img' ? 'clock in' : 'clock out';

                // check file empty
                if (jQuery('input[name=' + attr_name + ']')[0].files[0] === undefined) {
                    alert('File ' + message + ' tidak boleh kosong!');
                    return false;
                }

                // check file extension
                let name = modal_create.find('#' + attr_name).prop("files")[0].name;
                let ext = name.split('.').pop().toLowerCase();

                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert('Format file ' + message + ' tidak sesuai!');
                    return false;
                }

                return true;
            }
        })
    </script>
@endsection