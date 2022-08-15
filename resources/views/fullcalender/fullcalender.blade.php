@extends('master')
@section('title')
    Calendar
@endsection
@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!--fullcalendar plugin files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    
    <!-- for plugin notification -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
  
<div class="container mb-5">
    <div class="card">
        <div id="calendar" class="card-body"></div>
</div>
   
<script>
  var site_url = "{{ url('/') }}";
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        var calendar = $('#calendar').fullCalendar({
        header: {
            left:'title',
            center:'prev,next today',
            right:'month,agendaWeek,agendaDay'
        },
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
    $('.fc-center').css('float','left');
});
</script>
</body>
</html>

@endsection
