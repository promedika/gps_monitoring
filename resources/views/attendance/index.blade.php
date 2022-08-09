@extends('master')
@section('title')
    Attendances
@endsection
@section('content')
<div class="title-bar">
    <h4 style="float:left">Attendances</h4>
</div>
<div id="responsiveTables" class="mb-5">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{date('d-m-Y', strtotime($attendance->date))}}</td>
                            <td>{{$attendance->user['first_name']}} {{$attendance->user['last_name']}}</td>
                            <td>{{$attendance->start_time}}</td>
                            <td>{{$attendance->end_time}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
</div>    

@endsection
@endsection