@extends('master')
@section('title')
    Create Attendance
@endsection
@section('custom_link_css')
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('/assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: linen">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Clock Out</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>

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
                            <form action="{{ route('attendances.upload') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group">
                                    <label class="font-weight-bold">Foto</label>
                                    <br>
                                    @error('image')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    @if (session()->has('message'))
                                        <div class="alert alert-danger mt-2">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    <button id="open_cam" class="btn btn-md btn-info"><i class="fa fa-camera-retro"></i>
                                        Kamera</button>
                                    <input type="file" name="file" id="file"
                                        class="form-control image @error('image') is-invalid @enderror" capture="camera"
                                        required style="display: none;">
                                    <input type="hidden" name="type" value="clock_out_img">
                                    <input type="hidden" name="note" value="teknisi">
                                    <!-- error message untuk title -->

                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Nama RS</label>
                                    <select id="outlet-dd" name="outlet_name" class="form-control" required>
                                        <option>Nama RS</option>
                                        @foreach ($outlets as $outlet)
                                            <option value="{{ $outlet->id . '|' . $outlet->name }}">
                                                {{ $outlet->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><br>
                                @if (Auth::User()->department == 0 || Auth::User()->department == 1 || Auth::User()->department == 6)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nama User</label>
                                        <select id="useroutlet-dd" name="useroutlet_name" class="form-control" required>
                                            <option value="">Pilih User</option>
                                        </select>
                                    </div>
                                @endif
                                <br>

                                <div class="form-group">
                                    <label class="font-weight-bold">Aktifitas</label>
                                    <br>
                                    <textarea id="activity" class=" appearance-none border rounded" rows="6" cols="110" style="max-width: 100%"
                                        name="keterangan" required></textarea>
                                </div>
                                <br>

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
    <script src="{{ asset('/assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#outlet-dd').select2({
                width: '100%',
                theme: 'bootstrap4',
            });

            var site_url = "{{ url('/') }}";

            if (screen.width >= 450) {
                alert('Anda Harus Absen Menggunakan Handphone !')
                location.href = site_url

            }

            $('#useroutlet-dd').select2({
                width: '100%',
                theme: 'bootstrap4',
            });
            var site_url = "{{ url('/') }}";
            $('#outlet-dd').on('change', function() {
                var idOutlet = this.value;
                $("#useroutlet-dd").html('');
                $.ajax({
                    url: site_url + "/api/fetch-useroutlet",
                    type: "POST",
                    data: {
                        outlet_id: idOutlet,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        $('#useroutlet-dd').after(
                            '<input type="hidden" name="jabatan_name" value="' + result[0]
                            .jabatan + '|' + result[0].jabatan_name + '">');
                        $('#useroutlet-dd').html('<option value="">Pilih User</option>');
                        $.each(result, function(key, value) {
                            let val = value.id + '|' + value.name
                            $("#useroutlet-dd").append('<option value="' + val + '">' +
                                value.name + '</option>');
                        });
                    }
                });
            });
            $('#submit').click(function() {
                if (
                    $('#file').val() != '' &&
                    $('#outlet-dd').val() != '' &&
                    // $('#useroutlet-dd').val() != '' &&
                    $('#activity').val() != ''
                ) {
                    $('#loader').modal('show');
                }

            });

            // open camera
            $('#open_cam').on('click', function(e) {
                e.preventDefault();
                $('#file').trigger('click');
            });

        });
    </script>
@endsection
