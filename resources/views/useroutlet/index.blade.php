@extends('master')
@section('title')
    User Tenant
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
          <h1 class="m-0">User Tenant</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
            <li class="breadcrumb-item active">User Tenant</li>
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
                      <a href="#" title="Add" class="btn btn-primary   col-2 btn-add-useroutlet"><i class="fa solid fa-plus"></i></a>
                      </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered table-hover" id="table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nama Tenant</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          @php $no = 1; @endphp
                          
                          @foreach ($useroutlets as $useroutlet)
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$useroutlet->user_outlets_name}}</td>
                            <td>{{$useroutlet->outlets_name}}</td>
                            <td>{{$useroutlet->jabatans_name}}</td>
                            <td>{{$useroutlet->user_outlets_status}}</td>
                            <td>
                              <a href="#" useroutlet-id="{{$useroutlet->user_outlets_id}}" title="Edit" class="btn btn-warning btn-edit-useroutlet"><i class="fas fa-edit"></i></a>
                              <a href="#" useroutlet-id="{{$useroutlet->user_outlets_id}}" data-useroutlet="{{$useroutlet->user_outlets_name}}" title="Delete" class="btn btn-danger btn-delete-useroutlet"><i class="fas fa-trash"></i></a>
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
              <!-- /.col -->
          </div>
          <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- The Modal Add -->
<div class="modal fade in" id="modalCreateUserOutlet" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Buat User Tenant Baru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="first_name">Nama User</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <span id="errorName" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="outlet_name">Nama Tenant</label>
            <select id="outlet-dd" name="outlet_id" class="form-control" required>
              <option value="">Pilih Lokasi</option>
              @foreach ($outlets as $outlet)
              <option value="{{$outlet->id}}">
                  {{$outlet->name}}
              </option>
              @endforeach
          </select>
          </div>

          <div class="form-group">
            <label for="Jabatan">Jabatan</label>
            <select id="jabatan" name="jabatan" class="form-control" required>
              <option value="" style="display:none;">Pilih Jabatan</option>
              @foreach ($jabatans as $jabatan)
              <option value="{{$jabatan->id}}">{{$jabatan->name}}</option>
              @endforeach
          </select>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status"  class="form-control" required>
              <option value=""style="display:none;">Pilih Status</option>
              <option value="AKTIF">AKTIF</option>
              <option value="EXPIRED">EXPIRED</option>
          </select>
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

<!-- The Modal Edit -->
<div class="modal fade in" id="modalEditUserOutlet" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ubah User Tenant</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Nama User</label>
          <input type="text" name="name" id="name_update" value="{{ old('user_outlets_name')}}" class="form-control" required>
          <span id="errorName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Nama Tenant</label>
          <select id="outlet_id_update" name="outlet_id" value="{{ old('outlets_name')}}" class="form-control" required>
              <option value="">Silahkan Pilih</option>
              @foreach ($outlets as $outlet)
              <option value="{{$outlet->id}}">{{$outlet->name}}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Jabatan">Jabatan</label>
          <select id="jabatan_update" name="jabatan" class="form-control" value="{{ old('jabatans_name')}}" required>
            <option value="">Pilih Jabatan</option>
            @foreach ($jabatans as $jabatan)
              <option value="{{$jabatan->id}}">{{$jabatan->name}}</option>
              @endforeach
        </select>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select id="status_update" name="status"  class="form-control" value="{{ old('status')}}" required>
            <option value=""style="display:none;">Pilih Status</option>
            <option value="AKTIF">AKTIF</option>
            <option value="EXPIRED">EXPIRED</option>
        </select>
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


<!-- The Modal Delete-->
<div class="modal fade in" id="modalDeleteUserOutlet" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-delete">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hapus User Tenant</h4>
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
        
        jQuery("body").on("click", ".btn-add-useroutlet", function(e){
            $('#modalCreateUserOutlet').modal('show');

            $('#form-signup').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalCreateUserOutlet');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.create')}}",
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
                        location.reload();
                    },
                    error:function(response){
                        $('#errorName').text(response.responseJSON.errors.name);
                        $('#errorOutlet_id').text(response.responseJSON.errors.outlet_id);
                    }
                })
            })
        })
          jQuery("body").on("click", ".btn-edit-useroutlet", function(e) {
            $('#modalEditUserOutlet').modal('show');
            var useroutletID = $(this).attr('useroutlet-id');
            var id = $('#id').val(useroutletID);
                $.ajax({
                    url:"{{route('useroutlet.edit')}}",
                    type:'POST',
                    data:{
                      id:useroutletID,
                    },
                    success:function(data){
                        $('#name_update').val(data.useroutlets.name);
                        $('#outlet_id_update').val(data.useroutlets.outlet_id);
                        $('#jabatan_update').val(data.useroutlets.jabatan);
                        $('#status_update').val(data.useroutlets.status);
                    },
                    error:function(response){
                        $('#errorName').text(response.responseJSON.errors.name);
                        $('#errorOutlet_id').text(response.responseJSON.errors.outlet_id);
                    }
                    
                })

                $('#form-edit').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalEditUserOutlet');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.update')}}",
                    type:'POST',
                    data:formData,
                    data:{
                      id:useroutletID,
                      name:$('#name_update').val(),
                      outlet_id:$('#outlet_id_update').val(),
                      jabatan:$('#jabatan_update').val(),
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
                        $('#errorName').text(response.responseJSON.errors.name);
                        $('#errorOutlet_id').text(response.responseJSON.errors.outlet_id);
                    }
                })
            })
        })

          
          jQuery("body").on("click", ".btn-delete-useroutlet", function(e) {
          $('#modalDeleteUserOutlet').find('.modal-body span').text($(this).data("useroutlet"));
          $('#modalDeleteUserOutlet').modal('show');
          var useroutletID = $(this).attr('useroutlet-id');
          var id = $('#id_delete').val(useroutletID);
          $('#form-delete').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalDeleteUserOutlet');
                // var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.delete')}}",
                    type:'POST',
                    data:{
                      id:useroutletID,
                    },
                    beforeSend: function() {
                      modal_id.find('.modal-footer button').prop('disabled',true);
                      modal_id.find('.modal-header button').prop('disabled',true);
                    },
                    success:function(data){
                        console.log('success deleted');
                        location.reload();
                    },
                    error:function(response){
                        console.log('success failed');
                    }
                })
            })
        })
    })
</script>
@endsection