@extends('master')
@section('title')
    Create Attendance
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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Image Attendance</a></li>
              <li class="breadcrumb-item active">Create</li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">Image</label>
                                <input type="file" class="form-control image @error('image') is-invalid @enderror" name="image">
                            
                                <!-- error message untuk title -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div><br>

                            <div class="form-group">
                                <select id="outlet-dd" name="outlet_name" class="form-control">
                                    <option value="">Select Location</option>
                                    @foreach ($outlets as $outlet)
                                    <option value="{{$outlet->id.'|'.$outlet->name}}">
                                        {{$outlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div><br>

                            <div class="form-group">
                                <select id="useroutlet-dd" name="useroutlet_name"  class="form-control">
                                    <option value="">Select PIC</option>
                                    {{-- @foreach ($useroutlets as $useroutlet)
                                    <option>
                                        {{$useroutlet->name}}
                                    </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                    $('#useroutlet-dd').html('<option value="">Select PIC</option>');
                    $.each(result, function( key, value ) {
                        let val = value.id + '|' + value.name
                    $("#useroutlet-dd").append('<option value="' + val + '">' + value.name + '</option>');
                    });
                }
            });
        });          
    });
</script>
