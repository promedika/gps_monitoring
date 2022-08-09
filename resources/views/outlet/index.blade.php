@extends('master')
@section('title')
    Outlet
@endsection
@section('content')
<div class="title-bar">
    <h4 style="float:left">Outlet</h4>
    <a href="#" title="" style="float:right" class="btn btn-primary btn-add-outlet"><i class="fa solid fa-plus"></i></a> 
</div>
<div id="responsiveTables" class="mb-5">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Outlet Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outlets as $outlet)
                        <tr>
                            <td>{{$outlet->id}}</td>
                            <td>{{$outlet->name}}</td>
                            <td>
                                <a href="#" outlet-id="{{$outlet->id}}" title="" class="btn btn-primary btn-edit-outlet"><i class="fa-solid fa-pencil"></i></a>
                                <a href="#" outlet-id="{{$outlet->id}}" title="" class="btn btn-warning btn-delete-outlet"><i class="fa-solid fa-trash-can"></i></a>
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
<div class="modal fade in" id="modalCreateOutlet">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-signup">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New Outlet</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Outlet Name</label>
            <input type="text" name="name" id="name" class="form-control">
            <span id="errorName" class="text-red"></span>
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
<div class="modal fade in" id="modalEditOutlet">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post" accept-charset="utf-8" id="form-edit">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Outlet
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <input type="hidden" name="id" id="id" class="form-control">
      <!-- Modal body -->  
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Outlet Name</label>
          <input type="text" name="name" id="name_update" class="form-control">
          <span id="errorName" class="text-red"></span>
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
  <div class="modal fade in" id="modalDeleteOutlet">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" accept-charset="utf-8" id="form-delete">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete Outlet</h4>
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
  @section('script')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-add-outlet').click(function(){
                $('#modalCreateOutlet').modal('show');

                $('#form-signup').submit(function(e){
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url:"{{route('outlet.create')}}",
                        type:'POST',
                        data:formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        enctype: 'multipart/form-data',
                        success:function(data){
                            console.log('success create');
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
                        },
                        error:function(response){
                            $('#errorName').text(response.responseJSON.errors.name);
                        }
                        
                    })

                    $('#form-edit').submit(function(e){
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url:"{{route('outlet.update')}}",
                        type:'POST',
                        data:formData,
                        data:{
                          id:outletID,
                          name:$('#name_update').val(),
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
                    // var formData = new FormData(this);
                    $.ajax({
                        url:"{{route('outlet.delete')}}",
                        type:'POST',
                        data:{
                          id:outletID,
                        },
                        success:function(data){
                            console.log('success deleted');
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