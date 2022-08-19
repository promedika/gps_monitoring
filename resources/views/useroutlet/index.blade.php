@extends('master')
@section('title')
    User Outlet
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users Outlet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
            <li class="breadcrumb-item active">Users Outlet</li>
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
                      <a href="#" title="Add" class="btn btn-primary btn-block col-2 btn-add-useroutlet"><i class="fa solid fa-plus"></i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Outlet Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $no = 1; @endphp
                          @foreach ($useroutlets as $useroutlet)
                          <tr>
                            <td>{{$no++}}</td>
                            <td>{{$useroutlet->name}}</td>
                            <td>{{$useroutlet->outlet->name}}</td>
                            <td>
                              <a href="#" useroutlet-id="{{$useroutlet->id}}" title="Edit" class="btn btn-warning btn-edit-useroutlet"><i class="fas fa-edit"></i></a>
                              <a href="#" useroutlet-id="{{$useroutlet->id}}" title="Delete" class="btn btn-danger btn-delete-useroutlet"><i class="fas fa-trash"></i></a>
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
          <h4 class="modal-title">Create New User Outlet</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="first_name">User Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <span id="errorName" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="last_name">Outlet Name</label>
            <select id="outlet-dd" name="outlet_id" value="{{ old('outlet_id')}}" class="form-control" required>
              <option value="">Select Location</option>
              @foreach ($outlets as $outlet)
              <option value="{{$outlet->id}}">
                  {{$outlet->name}}
              </option>
              @endforeach
          </select>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        <h4 class="modal-title">Edit User Outlet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name_update" class="form-control" required>
          <span id="errorName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Outlet Name</label>
          <select id="outlet_id_update" name="outlet_id" class="form-control" required>
              <option value="">Silahkan Pilih</option>
              @foreach ($outlets as $outlet)
              <option value="{{$outlet->id}}">{{$useroutlet->outlet->name}}</option>
              @endforeach
          </select>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
      <h4 class="modal-title">Delete User Outlet</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <input type="hidden" name="id" id="id_delete" class="form-control">

    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form>
  </div>
</div>
</div>
@endsection

@section('custom_script_js')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery("body").on("click", ".btn-add-useroutlet", function(e){
            $('#modalCreateUserOutlet').modal('show');

            $('#form-signup').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.create')}}",
                    type:'POST',
                    data:formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
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


        $('.btn-edit-useroutlet').click(function(){
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
                    },
                    error:function(response){
                        $('#errorName').text(response.responseJSON.errors.name);
                        $('#errorOutlet_id').text(response.responseJSON.errors.outlet_id);
                    }
                    
                })

                $('#form-edit').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.update')}}",
                    type:'POST',
                    data:formData,
                    data:{
                      id:useroutletID,
                      name:$('#name_update').val(),
                      outlet_id:$('#outlet_id_update').val(),
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

        $('.btn-delete-useroutlet').click(function(){
          $('#modalDeleteUserOutlet').modal('show');
          var useroutletID = $(this).attr('useroutlet-id');
          var id = $('#id_delete').val(useroutletID);
          $('#form-delete').submit(function(e){
                e.preventDefault();
                // var formData = new FormData(this);
                $.ajax({
                    url:"{{route('useroutlet.delete')}}",
                    type:'POST',
                    data:{
                      id:useroutletID,
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