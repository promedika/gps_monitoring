@extends('master')
@section('title')
    Laporan Absensi
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
            <h1 class="m-0">Laporan Absensi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Absensi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div>
                  <form action="{{route('reports.show_report')}}" method="post" accept-charset="utf-8" id="show-monthly-report">

                    @csrf

                  <div class="card-header" style="display: flex">
                    <div class="col-4  form-group">
                      <select name="user_fullname" id="user" class="form-control txtuser" required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}|{{$user->first_name." ".$user->last_name}}"{{($user->id == Session::get('user_id')) ? 'selected' : ''}}>
                          {{$user->first_name."".$user->last_name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-4 form-group">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input value="{{(is_null(Session::get('date'))) ? "Pilih Bulan & Tahun" : Session::get('date')}}" name="date" placeholder="Pilih Bulan & Tahun" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#reservationdate" readonly required/>
                        </div>
                    </div>
                    <div>
                    <input type="submit" value="Submit" class="btn btn-primary">
                    <button class="btn btn-success" id="excel" title="excel"><i class="fas fa-download"></i></button>
                    </div>
                  </form>
                  </div>
                    <div class="card-body table-responsive p-0" style="display: none">
                        <table class="table table-head-fixed table-hover" id="reports">
                              <tr>
                                <td style= "font-size:30px" data-f-sz="14" data-f-bold="true">Nama:</td>
                                <td colspan="2" style= "font-size:30px" data-f-sz="14" data-f-bold="true">{{(is_null(Session::get('user_name'))) ? "" : Session::get('user_name')}}</td>
                              </tr>
                              <tr>
                                <td style= "font-size:30px" data-f-sz="12" data-f-bold="true">Tahun & Bulan:</td>
                                <td style="font-size:25px" data-f-sz="12" data-f-bold="true">{{(is_null(Session::get('date'))) ? "" : Session::get('date')}}</td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="2" style="font-size:20px" data-f-sz="14" data-f-bold="true">Clock In/Out</td>
                              </tr>
                              <tr>
                               @foreach ($dataAtt[0] as $key => $value)
                                    @php $th = str_replace('day_','',$value); @endphp
                                    <th data-b-a-s="thick" data-f-bold="true" data-a-h="center" scope="col">{{$th}}</th>
                                @endforeach
                              </tr>
                              @if (count($dataAtt) == 1)
                                <tr class="att">
                                    <td data-b-a-s="thin" data-a-h="center" colspan="{{count($dataAtt[0])}}">
                                      <div class="alert alert-danger">
                                          <h6 align="center"> Data Kehadiran Belum Tersedia</h6>
                                      </div>
                                    </td>
                                </tr>
                                @else
                                @foreach ($dataAtt as $key => $value)
                                    @php if ($key == 0) continue; @endphp
                                    <tr class="data_att">
                                        @foreach ($value as $k => $v)
                                          @php $td = str_replace('_',' ',$v);@endphp
                                          @if ($key != count($dataAtt)-1)
                                          <td data-b-a-s="thin" data-a-h="center"><p>{{$td}}</p></td>
                                          @else
                                          <td data-b-a-s="thick" data-a-h="center"><b>{{$td}}</b></td>
                                          @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                              @endif
                                <tr>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                </tr>
                              <tr>    
                                <td colspan="2" style="font-size:20px" data-f-sz="14" data-f-bold="true">Kunjungan</td>
                              </tr>  
                              <tr>
                                <th scope="col" data-b-a-s="thick" data-a-h="center" data-f-bold="true">No</th>
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
                                    <th data-b-a-s="thick" data-f-bold="true" data-a-h="center" scope="col">{{$th}}</th>
                                @endforeach
                              </tr>
                    
                            
                              @if (count($data) == 2)
                                <tr class="visit">
                                    <td data-b-a-s="thin" data-a-h="center" colspan="{{count($data[0])+1}}">
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
                                        <td data-b-a-s="thin" data-a-h="center">{{$nomor++}}</td>
                                        @foreach ($value as $v)
                                        <td data-b-a-s="thin" data-a-h="center">{{$v}}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                              @endif
                            
                                @if (count($data) > 2)
                                <tr>
                                    <th data-b-a-s="thick" data-a-h="center" data-f-bold="true" scope="col" colspan="4">
                                      <p style="text-align: center" >Total Harian</p>
                                    </th>
                                    @foreach ($data[count($data)-1] as $key => $value)
                                        @php if ($key < 3) continue; @endphp
                                        <th data-b-a-s="thick" data-a-h="center" scope="col">{{$value}}</th>
                                    @endforeach
                                </tr>
                                @endif
                        </table>
                    </div>

                    {{-- table yang di view --}}
                    <div class="card">
                      <h5 style="margin-left: 10px; margin-top:10px;">Nama : {{(is_null(Session::get('user_name'))) ? "" : Session::get('user_name')}}</h5>
                      <h5 style="margin-left: 10px">Tahun & Bulan : {{(is_null(Session::get('date'))) ? "" : Session::get('date')}}</h5>
                    </div>
                    <div class="card table-responsive p-0">
                      <table class="table table-head-fixed table-hover" id="reports">
                            <tr>
                              <td colspan="35" style="font-size:20px" data-f-sz="14" data-f-bold="true">Clock In/Out</td>
                            </tr>
                            <tr>
                             @foreach ($dataAtt[0] as $key => $value)
                                  @php $th = str_replace('day_','',$value); @endphp
                                  <th data-b-a-s="thick" data-f-bold="true" data-a-h="center" scope="col">{{$th}}</th>
                              @endforeach
                            </tr>
                            @if (count($dataAtt) == 1)
                              <tr class="att">
                                  <td data-b-a-s="thin" data-a-h="center" colspan="{{count($dataAtt[0])}}">
                                    <div class="alert alert-danger">
                                        <h6 align="center"> Data Kehadiran Belum Tersedia</h6>
                                    </div>
                                  </td>
                              </tr>
                              @else
                              @foreach ($dataAtt as $key => $value)
                                  @php if ($key == 0) continue; @endphp
                                  <tr class="data_att">
                                      @foreach ($value as $k => $v)
                                        @php $td = str_replace('_',' ',$v);@endphp
                                        @if ($key != count($dataAtt)-1)
                                        <td><p>{{$td}}</p></td>
                                        @else
                                        <td><b>{{$td}}</b></td>
                                        @endif
                                      @endforeach
                                  </tr>
                              @endforeach
                            @endif
                      </table>
                    </div>
                    
                    <div class="card table-responsive p-0">
                      <table class="table table-head-fixed table-hover">
                            <tr>    
                              <td colspan="35" style="font-size:20px" data-f-sz="14" data-f-bold="true">Kunjungan</td>
                            </tr>  
                            <tr>
                              <th scope="col" data-b-a-s="thick" data-a-h="center" data-f-bold="true">No</th>
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
                                  <th data-b-a-s="thick" data-f-bold="true" data-a-h="center" scope="col">{{$th}}</th>
                              @endforeach
                            </tr>
                  
                          
                            @if (count($data) == 2)
                              <tr class="visit">
                                  <td data-b-a-s="thin" data-a-h="center" colspan="{{count($data[0])+1}}">
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
                                      <td data-b-a-s="thin" data-a-h="center">{{$nomor++}}</td>
                                      @foreach ($value as $v)
                                      <td data-b-a-s="thin" data-a-h="center">{{$v}}</td>
                                      @endforeach
                                  </tr>
                              @endforeach
                            @endif
                          
                              @if (count($data) > 2)
                              <tr>
                                  <th data-b-a-s="thick" data-a-h="center" data-f-bold="true" scope="col" colspan="4">
                                    <p style="text-align: center" >Total Harian</p>
                                  </th>
                                  @foreach ($data[count($data)-1] as $key => $value)
                                      @php if ($key < 3) continue; @endphp
                                      <th data-b-a-s="thick" data-a-h="center" scope="col">{{$value}}</th>
                                  @endforeach
                              </tr>
                              @endif
                      </table>
                    </div>
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