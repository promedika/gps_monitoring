@extends('master')
@section('title')
    Marketing Sales Target
@endsection

@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Select 2 -->
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Marketing Sales Target</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Marketing Sales Target</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --> 

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <a href="#" title="Add" class="btn btn-primary col-2 btn-add-user"><i class="fa solid fa-plus"></i></a>
                  {{-- <a href="#" title="Add" class="btn btn-success col-2 btn-import-user"><i class="fa solid fa-file-import"></i></a> --}}
                  </div>
                @if(session()->has('message'))
                    <div class="alert alert-danger mt-2">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('failure'))
                    <div class="alert alert-danger mt-2">
                        {{ session()->get('failure') }}
                    </div>
                @endif
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-hover" id="table">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Sales Target</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>Progress</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($targets as $target)
                            <tr>
                                <td>{{$target->first_name}} {{$target->last_name}}</td>
                                <td>{{$target->sales_target}}</td>
                                <td>{{explode(' ',$target->sales_start)[0]}}</td>
                                <td>{{explode(' ',$target->sales_end)[0]}}</td>
                                <td>{{$target->status}}</td>
                                <td>{{$target->pencapaian}}</td>
                            </tr>
                            @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- The Modal -->
<div class="modal fade in" id="modalCreateUser" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Buat Target Baru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="user_id">Nama P.I.C</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                <option value="{{$user->id}}">
                    {{$user->first_name}} {{$user->last_name}}
                </option>
                @endforeach
            </select>
            <span id="errorUser_id" class="text-red"></span>
          </div>
          
          <div class="form-group">
            <label for="sales_target">Sales Target</label>
            <input type="number" name="sales_target" id="sales_target" class="form-control"required>
            <span id="errorSalesTarget" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="sales_start">Start</label>
            <div class="input-group date" id="sales_start" data-target-input="nearest">
              <input name="sales_start" value="{{(is_null(Session::get('date'))) ? "Pilih Tanggal" : Session::get('date')}}" name="date" placeholder="Pilih Tanggal" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#sales_start" readonly required/>
            </div>
            <span id="errorStart" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="sales_end">End</label>
            <div class="input-group date" id="sales_end" data-target-input="nearest">
              <input name="sales_end" value="{{(is_null(Session::get('date'))) ? "Pilih Tanggal" : Session::get('date')}}" name="date" placeholder="Pilih Tanggal" type="text" class="form-control datetimepicker-input txtdate" data-toggle="datetimepicker" data-target="#sales_end" readonly required/>
            </div>
            <span id="errorEnd" class="text-red"></span>
          </div>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('custom_script_js')
<!-- DataTables  & Plugins -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Select 2 -->
<script src="{{asset('/assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Datepicker --> 
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#table').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });

        $('.btn-add-user').click(function(){
            $('#modalCreateUser').modal('show');

            $('#form-signup').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalCreateUser');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('sales.create')}}",
                    type:'POST',
                    data:formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    beforeSend: function() {
                      modal_id.find('.modal-footer button').prop('disabled',true);
                      modal_id.find('.modal-header button').prop('disabled',true);
                    },
                    success:function(data){
                        console.log('success create');
                        location.reload();
                    },
                })
            })

            $('#user_id').select2({
                dropdownParent: $('#modalCreateUser'),
                width:'100%',
                theme: 'bootstrap4',
            });

             $('#user_id').on('change', function() {
            console.log('test');
            var data = $("#user_id option:selected").val();
            $(".user_id").val(data);
            });

            $('#sales_start').datetimepicker({
            format: 'YYYY-MM-DD'
            });

            $('#sales_end').datetimepicker({
            format: 'YYYY-MM-DD'
            });
        })
    })
</script>
@endsection