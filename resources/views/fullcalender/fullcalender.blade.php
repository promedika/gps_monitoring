@extends('master')
@section('title')
    Calendar
@endsection
@section('custom_link_css')
  <!-- fullCalendar -->
  {{-- <link rel="stylesheet" href="{{asset('/assets/AdminLTE-3.2.0/plugins/fullcalendar/main.css')}}"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
  @endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linen">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Calendar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Calendar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
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
@endsection 

@section('custom_script_js')
<script>
    var site_url = "{{ url('/') }}";
</script>
{{-- <script src="{{asset('/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script> --}}
{{-- <script src="{{asset('/assets/AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script> --}}
{{-- <script src="{{asset('/assets/AdminLTE-3.2.0/plugins/fullcalendar/main.js')}}"></script>  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
{{-- <script>
    $(function () {
  
      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()
  
      var Calendar = FullCalendar.Calendar;
      var calendarEl = document.getElementById('calendar');
  
      var calendar = new Calendar(calendarEl, {
        headerToolbar: {
          left  : 'prev,next today',
          center: 'title',
          right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        //Random default events
        events: site_url + "/event",
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
      });
  
      calendar.render();
      // $('#calendar').fullCalendar()
  
      /* ADDING EVENTS */
      // var currColor = '#3c8dbc' //Red by default
      // // Color chooser button
      // $('#color-chooser > li > a').click(function (e) {
      //   e.preventDefault()
      //   // Save color
      //   currColor = $(this).css('color')
      //   // Add color effect to button
      //   $('#add-new-event').css({
      //     'background-color': currColor,
      //     'border-color'    : currColor
      //   })
      // })
    })
  </script> --}}
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        var calendar = $('#calendar').fullCalendar({
        header: {
            left:'',
            center:'title,prev,next,today,month',
            right:''
        },
        contentHeight: 600,
        editable: true,
        events: site_url + "/event",
        displayEventTime:false,
        editable: true,
        aspectRatio: 2.3,
        eventRender: function(event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        dayClick: function(date, jsEvent, view) {
        $('#calendar').fullCalendar('changeView', 'agendaDay')
        $('#calendar').fullCalendar('gotoDate', date);
        }
    });
    // $('.fc-center').css('float','left')

    if($(window).width()<=477){

    }
});
</script>
@endsection
