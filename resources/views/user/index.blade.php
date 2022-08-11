@extends('master')
@section('title')
    Users
@endsection
@section('content')

<div class="title-bar">
    <h4 style="float:left">Users</h4>
    <a href="#" title="" style="float:right" class="btn btn-primary btn-add-user"><i class="fa solid fa-plus"></i></a> 
</div>
<div id="responsiveTables" class="mb-5">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th><img src="{{asset('/assets/uploads/profiles/')}}/{{$user->profile}}" alt="" style="width: 30px;"></th>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{date('d-m-Y', strtotime($user->start_date))}}</td>
                            <td>{{date('d-m-Y', strtotime($user->end_date))}}</td>
                            <td>
                                <a href="#" user-id="{{$user->id}}" title="" class="btn btn-primary btn-edit-user"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#" user-id="{{$user->id}}" title="" class="btn btn-warning btn-delete-user"><i class="fa-solid fa-trash-can"></i></a>
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
<div class="modal fade in" id="modalCreateUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control">
            <span id="errorFirstName" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
            <span id="errorLastName" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control">
            <span id="errorEmail" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            <span id="errorPassword" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="Role">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="" style="display:none;">Select Role</option>
                <option value="0">Admin</option>
                <option value="1">Member</option>
            </select>
            <span id="errorRole" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
            <span id="errorStartDate" class="text-red"></span>
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
            <span id="errorEndDate" class="text-red"></span>
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
<div class="modal fade in" id="modalEditUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" name="first_name" id="first_name_update" class="form-control">
          <span id="errorFirstName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" name="last_name" id="last_name_update" class="form-control">
          <span id="errorLastName" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email_update" class="form-control">
          <span id="errorEmail" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="Role">Role</label>
          <select class="form-control" id="role_update" name="role">
              <option value="" style="display:none;">Select Role</option>
              <option value="0">Admin</option>
              <option value="1">Member</option>
              <option value="2">Supervisor</option>
          </select>
          <span id="errorRole" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="start_date">Start Date</label>
          <input type="date" name="start_date" id="start_date_update" class="form-control">
          <span id="errorStartDate" class="text-red"></span>
        </div>
        <div class="form-group">
          <label for="end_date">End Date</label>
          <input type="date" name="end_date" id="end_date_update" class="form-control">
          <span id="errorEndDate" class="text-red"></span>
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
  <div class="modal fade in" id="modalDeleteUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-delete">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete User</h4>
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
            $('.btn-add-user').click(function(){
                $('#modalCreateUser').modal('show');

                $('#form-signup').submit(function(e){
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url:"{{route('dashboard.users.create')}}",
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
                            $('#errorFirstName').text(response.responseJSON.errors.first_name);
                            $('#errorLastName').text(response.responseJSON.errors.last_name);
                            $('#errorEmail').text(response.responseJSON.errors.email);
                            $('#errorPassword').text(response.responseJSON.errors.password);
                            $('#errorRole').text(response.responseJSON.errors.role);
                            $('#errorStartDate').text(response.responseJSON.errors.start_date);
                            $('#errorEndDate').text(response.responseJSON.errors.end_date);
                        }
                    })
                })
            })


            $('.btn-edit-user').click(function(){
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
                            $('#role_update').val(data.data.role);
                            $('#start_date_update').val(data.data.start_date);
                            $('#end_date_update').val(data.data.end_date);
                        },
                        error:function(response){
                            $('#errorFirstName').text(response.responseJSON.errors.first_name);
                            $('#errorLastName').text(response.responseJSON.errors.last_name);
                            $('#errorEmail').text(response.responseJSON.errors.email);
                            $('#errorPassword').text(response.responseJSON.errors.password);
                            $('#errorRole').text(response.responseJSON.errors.role);
                            $('#errorStartDate').text(response.responseJSON.errors.start_date);
                            $('#errorEndDate').text(response.responseJSON.errors.end_date);
                        }
                        
                    })

                    $('#form-edit').submit(function(e){
                    e.preventDefault();
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
                          role:$('#role_update').val(),
                          start_date:$('#start_date_update').val(),
                          end_date:$('#end_date_update').val(),
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
                            $('#errorRole').text(response.responseJSON.errors.role);
                            $('#errorStartDate').text(response.responseJSON.errors.start_date);
                            $('#errorEndDate').text(response.responseJSON.errors.end_date);
                        }
                    })
                })
            })

            $('.btn-delete-user').click(function(){
              $('#modalDeleteUser').modal('show');
              var usrID = $(this).attr('user-id');
              var id = $('#id_delete').val(usrID);
              $('#form-delete').submit(function(e){
                    e.preventDefault();
                    // var formData = new FormData(this);
                    $.ajax({
                        url:"{{route('dashboard.users.delete')}}",
                        type:'POST',
                        data:{
                          id:usrID,
                        },
                        success:function(data){
                            console.log('success deleted');
                            location.reload()
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