@extends('master')
@section('title')
    Image Attendance
@endsection
@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Attendance Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Attendance Reports</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card">
                  <form action="{{route('reports.show_report')}}" method="post" accept-charset="utf-8" id="show-monthly-report">

                    @csrf

                  <div class="card-header" style="display: flex">
                    <div class="col-4  form-group">
                      <select name="user_fullname" id="user" class="form-control txtuser" required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">
                          {{$user->first_name."".$user->last_name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-4 form-group">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          @if($tmp_data['status'] = 'no')
                          <input name="date" placeholder="Pilih Bulan & Tahun" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#reservationdate" readonly required/>
                          @else
                          <input value="{{$tmp_data['date']}}" name="date" placeholder="Pilih Bulan & Tahun" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#reservationdate" readonly required/>
                          @endif
                        </div>
                    </div>
                    <div>
                    <input type="submit" value="Submit" class="btn btn-primary">
                    <button class="btn btn-primary" id="excel" title="excel"><i class="fas fa-download"></i></button>
                    </div>
                  </form>
                  </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed table-hover" id="reports">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                               @foreach ($data[0] as $key => $value)
                                    @php
                                    $th = str_replace('day_','',$value);
                                    if($key == count($data[0])-1) {
                                        $th = 'Total Bulanan';
                                    } elseif ($key == 0) {
                                        $th = 'PIC RS';
                                    } elseif ($key == 1) {
                                        $th = 'Jabatan';
                                    } elseif ($key == 2) {
                                        $th = 'RS';
                                    }
                                    @endphp
                                    <th scope="col">{{$th}}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @if (count($data) == 2)
                                <tr class="visit">
                                    <td colspan="{{count($data[0])+1}}">
                                      <div class="alert alert-danger">
                                          <h6 align="center"> Data post Belum Tersedia</h6>
                                      </div>
                                    </td>
                                </tr>
                                @else
                                @php $nomor = 1; @endphp
                                @foreach ($data as $key => $value)
                                    @php if ($key == 0 || $key == count($data)-1) continue; @endphp
                                    <tr class="data_post">
                                        <td>{{$nomor++}}</td>
                                        @foreach ($value as $v)
                                        <td>{{$v}}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                              @endif
                            </tbody>
                            <tfoot>
                                @if (count($data) > 2)
                                <tr>
                                    <th scope="col" colspan="4">
                                      <p style="text-align: center" >Total Harian</p>
                                    </th>
                                    @foreach ($data[count($data)-1] as $key => $value)
                                        @php if ($key < 3) continue; @endphp
                                        <th scope="col">{{$value}}</th>
                                    @endforeach
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
@section('custom_script_js')
<!-- Datepicker --> 
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/jquery-table/tableToExcel.js')}}"></script>
<script>
   $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Date picker
    $('#reservationdate').datetimepicker({
        viewMode: 'months', 
        format: 'YYYY-MM'
    });

    $('#excel').on('click', function (e) {
      e.preventDefault();

      let user_fullname = $('.txtuser').val();
      let date = $('.txtdate').val()
      let table = $("#reports")[0];
      let filename = "reports.xlsx";

      TableToExcel.convert(table, {
        name: filename,
        sheet: {
          name: "Report"
        }
      });


    });
  });
  
</script>
@endsection