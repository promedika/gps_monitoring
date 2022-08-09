@extends('master')
@section('title')
    Create User Outlet
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
                        <form action="{{ route('useroutlet.store') }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">Nama User</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <span id="errorName" class="text-red"></span>
                            </div>

                            <div class="form-group">
                                <select id="outlet-dd" name="outlet_name" value="{{ old('outlet_name')}}" class="form-control">
                                    <option value="">Select Location</option>
                                    @foreach ($outlets as $outlet)
                                    <option value="{{$outlet->id}}">
                                        {{$outlet->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select id="useroutlet-dd" name="useroutlet_name" value="{{ old('outlet_user')}}" class="form-control">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#outlet-dd').on('change', function () {
            var idOutlet = this.value;
            $("#usroutlet-dd").html('');
            $.ajax({
                url: "{{url('api/fetch-usroutlet')}}",
                type: "POST",
                data: {
                    outlet_id: idOutlet,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#usroutlet-dd').html('<option value="">Select PIC</option>');
                    $.each(result.outletusrs, function (key, value)) {
                        $("#usroutlet-dd").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });

</body>
</html>
@endsection