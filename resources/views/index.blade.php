@extends('master')
@section('title')
    Dashboard
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background: linen;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Home</li>
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
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <a href="#" id="newatt" title="newatt" style="color:white"><img src="{{asset('assets/img/camera-icon.png')}}" style="width: 100%">New Attendance</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
  	</div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<div class="modal fade in" id="modalCreateNewAtt" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      {{-- <form action="javascript:void(0)" method="post" accept-charset="utf-8" id="form-newatt"> --}}
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Attendance</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <button for="clockin" class="btn btn-md btn-primary" id="clock_in_btn">Clock In</button>
          <input type="file" name="clock_in_img" id="clock_in_img" class="form-control" style="display:none" accept="image/*" capture="camera"> 
          
          <a href="{{route('posts.create')}}"><button for="visit" class="btn btn-md btn-success" id="visit_btn">Visit</button></a>

          <button for="clockin" id="clock_out_btn" class="btn btn-md btn-primary">Clock Out</button>
          <input type="file" name="clock_out_img" id="clock_out_img" class="form-control" style="display:none" accept="image/*" capture="camera">
        </div>
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

  let modal_create = $('#modalCreateNewAtt');

  $('#newatt').click(function(){
      modal_create.modal('show');
  })

  // clock in
  modal_create.find('#clock_in_btn').on('click', function (e) {
    e.preventDefault();
    modal_create.find('#clock_in_img').trigger('click');
    submit_att('clock_in_img');
  });

  // clock out
  modal_create.find('#clock_out_btn').on('click', function (e) {
    e.preventDefault();
    modal_create.find('#clock_out_img').trigger('click');
    submit_att('clock_out_img');
  });

  function submit_att(type_att) {
    let message_att = type_att == 'clock_in_img' ? 'clock in' : 'clock out';

    modal_create.find('#'+type_att).on('change', function (e) {
      e.preventDefault();

      console.log(type_att);

      // validate image
      let validate = validate_img(''+type_att);

      if (validate) {
        var file_data = jQuery(this).prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('type', type_att);

        console.log(form_data);

        $.ajax({
          type: 'POST',
          url:"{{route('attendances.upload')}}",
          data: form_data,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function() {
            modal_create.find('#clock_in_img').prop('disabled',true);
            modal_create.find('#clock_out_img').prop('disabled',true);
            modal_create.find('#visit_btn').prop('disabled',true);
          },
          success: (data) => {
            alert(data);
            location.reload();
          },
          error: function(data) {
            alert(data);
            location.reload();
          }
        });
      }
    });
  }

  // validate file image
  function validate_img(attr_name) {
    let message = attr_name == 'clock_in_img' ? 'clock in' : 'clock out';

    // check file empty
    if (jQuery('input[name='+attr_name+']')[0].files[0] === undefined) {
      alert('File '+message+' tidak boleh kosong!');
      return false;
    }
      
    // check file extension
    let name = modal_create.find('#'+attr_name).prop("files")[0].name;
    let ext = name.split('.').pop().toLowerCase();

    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
      alert('Format file '+message+' tidak sesuai!');
      return false;
    }

    return true;
  }
})
</script>
@endsection