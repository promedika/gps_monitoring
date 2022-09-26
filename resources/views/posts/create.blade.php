@extends('master')
@section('title')
    Create Attendance
@endsection
@section('custom_link_css')
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
                                <input type="file" id="upload" class="form-control image @error('image') is-invalid @enderror" name="image" required>
                            
                                <!-- error message untuk title -->
                                
                            </div><br>

                            <div class="form-group">
                                <label class="font-weight-bold">Nama Tenant</label>
                                <select id="outlet-dd" name="outlet_name" class="form-control" required>
                                    <option value="">Select Location</option>
                                    @foreach ($outlets as $outlet)
                                    <option value="{{$outlet->id.'|'.$outlet->name}}">
                                        {{$outlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div><br>

                            <div class="form-group">
                                <label class="font-weight-bold">Nama User</label>
                                <select id="useroutlet-dd" name="useroutlet_name"  class="form-control" required>
                                    <option value="">Pilih User</option>
                                </select>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="font-weight-bold">Aktifitas</label>
                                <br>
                                <textarea id="activity" class=" appearance-none border rounded" rows="6" cols="110" style="max-width: 100%" name="activity" required></textarea> 
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
@endsection
@section('custom_script_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
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
                    $('#useroutlet-dd').html('<option value="">Select PIC</option>');
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
                $('#outlet-dd') != '' &&
                $('#useroutlet-dd') != '' &&
                $('#activity')
            ){
                $('#loader').modal('show');
            }
            
        });

    });
</script>
@endsection