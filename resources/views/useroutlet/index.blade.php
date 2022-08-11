@extends('master')
@section('title')
    User Outlet
@endsection
@section('content')
<div class="title-bar">
    <h4 style="float:left">Users Outlet</h4>
    <a href="#" title="" style="float:right" class="btn btn-primary btn-add-useroutlet"><i class="fa solid fa-plus"></i></a> 
</div>
<div id="responsiveTables" class="mb-5">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Outlet Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($useroutlets as $useroutlet)
                        <tr>
                            <td>{{$useroutlet->id}}</td>
                            <td>{{$useroutlet->name}}</td>
                            <td>{{$useroutlet->outlet->name}}</td>
                            <td>
                                <a href="#" useroutlet-id="{{$useroutlet->id}}" title="" class="btn btn-primary btn-edit-useroutlet"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#" useroutlet-id="{{$useroutlet->id}}" title="" class="btn btn-warning btn-delete-useroutlet"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
<!-- The Modal -->
<div class="modal fade in" id="modalCreateUserOutlet">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New User Outlet</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="first_name">User Name</label>
            <input type="text" name="name" id="name" class="form-control">
            <span id="errorName" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="last_name">Outlet Name</label>
            <select id="outlet-dd" name="outlet_id" value="{{ old('outlet_id')}}" class="form-control">
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
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- The Modal -->
<div class="modal fade in" id="modalEditUserOutlet">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit User Outlet</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name_update" class="form-control">
          <span id="errorName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Outlet Name</label>
          <select id="outlet_id_update" name="outlet_id" class="form-control">
              <option value="">{{$useroutlet->outlet->name}}</option>
              @foreach ($outlets as $outlet)
              <option value="{{$outlet->id}}"></option>
              @endforeach
          </select>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


  <!-- The Modal -->
  <div class="modal fade in" id="modalDeleteUserOutlet">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-delete">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete User Outlet</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <input type="hidden" name="id" id="id_delete" class="form-control">
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('/assets/js/	vendor.min.js')}}"></script>
  @section('script')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-add-useroutlet').click(function(){
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
                            console.log('success create');
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
                            console.log('success edit');
                            $('#name_update').val(data.data.name);
                            $('#outlet_id_update').val(data.data.outlet_id);
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
@endsection