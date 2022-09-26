@extends('master')
@section('title')
    Users
@endsection

@section('custom_link_css')
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                  <a href="#" title="Add" class="btn btn-success col-2 btn-import-user"><i class="fa solid fa-file-import"></i></a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                            <tr>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{date('d-m-Y', strtotime($user->start_date))}}</td>
                                <td>{{date('d-m-Y', strtotime($user->end_date))}}</td>
                                <td>{{$user->status}}</td>
                                <td>
                                  <a href="#" user-id="{{$user->id}}" title="" class="btn btn-warning btn-edit-user"><i class="fas fa-edit"></i></a>
                                  <a href="#" user-id="{{$user->id}}" data-user="{{$user->first_name.' '.$user->last_name}}" title="" class="btn btn-danger btn-delete-user"><i class="fas fa-trash"></i></a>
                                  
                                  </td>
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

<div class="modal fade in" id="modal-import-user" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('dashboard.users.upload')}}" method="post" accept-charset="utf-8" id="form-import" enctype="multipart/form-data">
        @csrf
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Import Data P.I.C</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <p><font color="red">* Format file harus .xlsx atau .xls</font></p>
          <a class="btn btn-sm btn-info" href="{{asset('/assets/template/pic_template.xlsx')}}">Download Template</a><br><br>
          <label for="name">Pilih File</label>
          <input type="file" name="file" class="name" id="name" accept=".xlsx, .xls" required >
          <span id="errorName" class="text-red"></span>
        </div>
      </div>

        <div class="modal-footer">
          <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
        </form>
      </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade in" id="modalCreateUser" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" id="form-signup">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Buat P.I.C Baru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <label for="first_name">Nama Depan</label>
          <input type="text" name="first_name" id="first_name" class="form-control" required>
          <span id="errorFirstName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Nama Belakang</label>
          <input type="text" name="last_name" id="last_name" class="form-control"required>
          <span id="errorLastName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email" class="form-control"required>
          <span id="errorEmail" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control"required>
          <span id="errorPassword" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="department">Departemen</label>
          <select class="form-control" id="department" name="department"required>
              <option value="" style="display:none;">Pilih departemen</option>
              <option value="0">IT</option>
              <option value="1">Marketing</option>
              <option value="2">H.R Department</option>
          </select>
          <span id="errorRole" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="Role">Role</label>
          <select class="form-control" id="role" name="role"required>
              <option value="" style="display:none;">Pilih Role</option>
              @if (Auth::user()->role ==0)
              <option value="0">Admin</option>
              @endif
              <option value="1">Marketing Member</option>
              <option value="2">Marketing Report</option>
          </select>
          <span id="errorRole" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="start_date">Tanggal Bergabung</label>
          <input type="date" name="start_date" id="start_date" class="form-control"required>
          <span id="errorStartDate" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="end_date">Tanggal Keluar</label>
          <input type="date" name="end_date" id="end_date" class="form-control"required>
          <span id="errorEndDate" class="text-red"></span>
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


<!-- The Modal -->
<div class="modal fade in" id="modalEditUser" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ubah P.I.C</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="first_name">Nama Depan</label>
          <input type="text" name="first_name" id="first_name_update" class="form-control" required>
          <span id="errorFirstName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Nama Belakang</label>
          <input type="text" name="last_name" id="last_name_update" class="form-control" required>
          <span id="errorLastName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email_update" class="form-control" readonly>
          <span id="errorEmail" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="password">Password <span style="font-size: 10px; color:red">*Kosongkan jika tidak ingin merubah password</span></label>
          <input type="password" name="password" id="password_update" class="form-control">
          <span id="errorPassword" class="text-red"></span>
        </div>
        <div class="form-group">
        <label for="department">Departemen</label>
          <select class="form-control" id="department_update" name="department"required>
              <option value="" style="display:none;">Pilih departemen</option>
              <option value="0">IT</option>
              <option value="1">Marketing</option>
              <option value="2">H.R Department</option>
          </select>
          <span id="errorDepartment" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="Role">Role</label>
          <select class="form-control" id="role_update" name="role" required>
              <option value="" style="display:none;">Select Role</option>
              @if (Auth::user()->role == 0)
              <option value="0">Admin</option>
              @endif
              <option value="1">Marketing Member</option>
              <option value="2">Marketing Report</option>
          </select>
          <span id="errorRole" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="start_date">Tanggal Bergabung</label>
          <input type="date" name="start_date" id="start_date_update" class="form-control" required>
          <span id="errorStartDate" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="end_date">Tanggal Keluar</label>
          <input type="date" name="end_date" id="end_date_update" class="form-control" required>
          <span id="errorEndDate" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="end_date">Status</label>
          <select name="status" id="status_update" class="form-control" required>
            <option value="" style="display:none;">Select Status</option>
              <option value="active">Active</option>
              <option value="expired">Expired</option>
          </select>
          <span id="errorStatus" class="text-red"></span>
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


<!-- The Modal -->
<div class="modal fade in" id="modalDeleteUser" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" id="form-delete">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hapus P.I.C</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id_delete" class="form-control">

      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus data <span></span> ini ?</p>
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

        $('.btn-import-user').click(function(){
            $('#modal-import-user').modal('show');
          });

          $('#submit').click(function(){
            $('#modal-import-user').modal('hide');
                      $('#loader').modal ('show');
                    });

        $('.btn-add-user').click(function(){
            $('#modalCreateUser').modal('show');

            $('#form-signup').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalCreateUser');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('dashboard.users.create')}}",
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
                    error:function(response){
                        $('#errorFirstName').text(response.responseJSON.errors.first_name);
                        $('#errorLastName').text(response.responseJSON.errors.last_name);
                        $('#errorEmail').text(response.responseJSON.errors.email);
                        $('#errorPassword').text(response.responseJSON.errors.password);
                        $('#errorDepartment').text(response.responseJSON.errors.department);
                        $('#errorRole').text(response.responseJSON.errors.role);
                        $('#errorStartDate').text(response.responseJSON.errors.start_date);
                        $('#errorEndDate').text(response.responseJSON.errors.end_date);

                        modal_id.find('.modal-footer button').prop('disabled',false);
                        modal_id.find('.modal-header button').prop('disabled',false);
                    }
                })
            })
        })


        jQuery("body").on("click", ".btn-edit-user", function(e) {
            $('#modalEditUser').modal('show');
            var userID = $(this).attr('user-id');
            var id = $('#id').val(userID);
                $.ajax({
                    url:"{{route('dashboard.users.edit')}}",
                    type:'POST',
                    data:{
                      id:userID,
                    },
                    success:function(data){
                        console.log('success edit');
                        $('#first_name_update').val(data.data.first_name);
                        $('#last_name_update').val(data.data.last_name);
                        $('#email_update').val(data.data.email);
                        $('#password_update').val(data.data.password);
                        $('#department_update').val(data.data.department);
                        $('#role_update').val(data.data.role);
                        $('#start_date_update').val(data.data.start_date);
                        $('#end_date_update').val(data.data.end_date);
                        $('#status_update').val(data.data.status);
                    },
                    error:function(response){
                        $('#errorFirstName').text(response.responseJSON.errors.first_name);
                        $('#errorLastName').text(response.responseJSON.errors.last_name);
                        $('#errorEmail').text(response.responseJSON.errors.email);
                        $('#errorPassword').text(response.responseJSON.errors.password);
                        $('#errorDepartment').text(response.responseJSON.errors.department);
                        $('#errorRole').text(response.responseJSON.errors.role);
                        $('#errorStartDate').text(response.responseJSON.errors.start_date);
                        $('#errorEndDate').text(response.responseJSON.errors.end_date);
                    }
                    
                })

                $('#form-edit').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalEditUser');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('dashboard.users.update')}}",
                    type:'POST',
                    data:formData,
                    data:{
                      id:userID,
                      first_name:$('#first_name_update').val(),
                      last_name:$('#last_name_update').val(),
                      email:$('#email_update').val(),
                      password:$('#password_update').val(),
                      department:$('#department_update').val(),
                      role:$('#role_update').val(),
                      start_date:$('#start_date_update').val(),
                      end_date:$('#end_date_update').val(),
                      status:$('#status_update').val(),
                    },
                    beforeSend: function() {
                      modal_id.find('.modal-footer button').prop('disabled',true);
                      modal_id.find('.modal-header button').prop('disabled',true);
                    },
                    success:function(data){
                        console.log('success update');
                        location.reload();
                    },
                    error:function(response){
                        $('#errorFirstName').text(response.responseJSON.errors.first_name);
                        $('#errorLastName').text(response.responseJSON.errors.last_name);
                        $('#errorEmail').text(response.responseJSON.errors.email);
                        $('#errorPassword').text(response.responseJSON.errors.password);
                        $('#errorDepartment').text(response.responseJSON.errors.department);
                        $('#errorRole').text(response.responseJSON.errors.role);
                        $('#errorStartDate').text(response.responseJSON.errors.start_date);
                        $('#errorEndDate').text(response.responseJSON.errors.end_date);

                        modal_id.find('.modal-footer button').prop('disabled',false);
                        modal_id.find('.modal-header button').prop('disabled',false);
                    }
                })
            })
        })

          jQuery("body").on("click", ".btn-delete-user", function(e) {
          $('#modalDeleteUser').find('.modal-body span').text($(this).data("user"));
          $('#modalDeleteUser').modal('show');
          var usrID = $(this).attr('user-id');
          var id = $('#id_delete').val(usrID);
          $('#form-delete').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalCreateUser');
                $.ajax({
                    url:"{{route('dashboard.users.delete')}}",
                    type:'POST',
                    data:{
                      id:usrID,
                    },
                    beforeSend: function() {
                      modal_id.find('.modal-footer button').prop('disabled',true);
                      modal_id.find('.modal-header button').prop('disabled',true);
                    },
                    success:function(data){
                        console.log('success deleted');
                        location.reload()
                    },
                    error:function(response){
                        console.log('success failed');
                        location.reload()
                    }
                })
            })
        })
    })
</script>
@endsection