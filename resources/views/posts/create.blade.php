@extends('master')
@section('title')
    Create Attendance
@endsection
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | GPS HRMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
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
                            </div>

                            <div class="form-group">
                                <select id="outlet-dd" name="outlet_name" class="form-control">
                                    <option value="">Select Location</option>
                                    @foreach ($outlets as $outlet)
                                    <option>
                                        {{$outlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select id="useroutlet-dd" name="useroutlet_name"  class="form-control">
                                    <option value="">Select PIC</option>
                                    @foreach ($useroutlets as $useroutlet)
                                    <option>
                                        {{$useroutlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#outlet-dd').on('change', function () {
            var idOutlet = this.value;
            $("#useroutlet-dd").html('');
            $.ajax({
                url: "{{url('api/fetch-useroutlet')}}",
                type: "POST",
                data: {
                    outlet_id: idOutlet,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#useroutlet-dd').html('<option value="">Select PIC</option>');
                    $.each(result.useroutlet, function (key, value)) {
                        $("#useroutlet-dd").append('<option value="' + value.id + '">' + value.name + '</option>');
                    };
                }; 
            });
        });          
    });
</script>
