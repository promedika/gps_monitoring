@extends('master')
@section('title')
    Tenant
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
          <h1 class="m-0">Tenant</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Beranda</a></li>
            <li class="breadcrumb-item active">Tenant</li>
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
                      <a href="#" title="Add" class="btn btn-primary col-2 btn-add-outlet"><i class="fa solid fa-plus"></i></a>
                      <a href="#" title="Add" class="btn btn-success col-2 btn-import-outlet"><i class="fa solid fa-file-import"></i></a>
                    </div>
                    @if(session()->has('message'))
                    <div class="alert alert-danger mt-2">
                        {{ session()->get('message') }}
                    </div>
                @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered table-hover" id="table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Tenant</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $no = 1; @endphp
                          @foreach ($outlets as $outlet)
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$outlet->name}}</td>
                            <td>
                                <a href="#" outlet-id="{{$outlet->id}}" title="Edit" class="btn btn-warning btn-edit-outlet"><i class="fas fa-edit"></i></a>
                                <a href="#" outlet-id="{{$outlet->id}}" title="Delete" class="btn btn-danger btn-delete-outlet"><i class="fas fa-trash"></i></a>
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

<!-- The Modal Import -->
<div class="modal fade in" id="modal-import-outlet" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('outlet.upload')}}" method="post" accept-charset="utf-8" id="form-import" enctype="multipart/form-data">
        @csrf
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Import Data Tenant</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <p><font color="red">* Format file harus .xlsx atau .xls</font></p>
          <a class="btn btn-sm btn-info" href="{{asset('/assets/template/tenant_template.xlsx')}}">Download Template</a><br><br>
          <label for="name">Pilih File</label>
          <input type="file" name="file" class="name" id="name" accept=".xlsx" required >
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

<!-- The Modal Add -->
<div class="modal fade in" id="modalCreateOutlet" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Buat Tenant Baru</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama Tenant</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <span id="errorName" class="text-red"></span>
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
<div class="modal fade in" id="modalEditOutlet" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ubah Tenant
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Nama Tenant</label>
          <input type="text" name="name" id="name_update" class="form-control" required>
          <span id="errorName" class="text-red"></span>
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

<!-- The Modal Delete -->
<div class="modal fade in" id="modalDeleteOutlet" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-delete">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Tenant</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" name="id" id="id_delete" class="form-control">
  
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

        $('.btn-import-outlet').click(function(){
            $('#modal-import-outlet').modal('show');
          });

          $('#submit').click(function(){
            $('#modal-import-outlet').modal('hide');
                      $('#loader').modal ('show');
                    });

        $('.btn-add-outlet').click(function(){
            $('#modalCreateOutlet').modal('show');

            $('#form-signup').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalCreateOutlet');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('outlet.create')}}",
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
                        $('#errorName').text(response.responseJSON.errors.name);
                    }

                    
                })
            })
        })


        $('.btn-edit-outlet').click(function(){
            $('#modalEditOutlet').modal('show');
            var outletID = $(this).attr('outlet-id');
            var id = $('#id').val(outletID);
            
            $.ajax({
                url:"{{route('outlet.edit')}}",
                type:'POST',
                data:{
                  id:outletID,
                },
                success:function(data){
                    console.log('success edit');
                    $('#name_update').val(data.data.name);
                    $('#form-edit').data('id',outletID);
                },
                error:function(response){
                    $('#errorName').text(response.responseJSON.errors.name);
                }
                
            })

            $('#form-edit').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalEditOutlet');
                let outletID = $(this).data('id');
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('outlet.update')}}",
                    type:'POST',
                    data:formData,
                    data:{
                      id:outletID,
                      name:$('#name_update').val(),
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
                    }
                })
            })
        })

        $('.btn-delete-outlet').click(function(){
          $('#modalDeleteOutlet').modal('show');
          var outletID = $(this).attr('outlet-id');
          var id = $('#id_delete').val(outletID);
          $('#form-delete').submit(function(e){
                e.preventDefault();
                let modal_id = $('#modalDeleteOutlet');
                // var formData = new FormData(this);
                $.ajax({
                    url:"{{route('outlet.delete')}}",
                    type:'POST',
                    data:{
                      id:outletID,
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