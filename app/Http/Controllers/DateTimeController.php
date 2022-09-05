<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DateTimeController extends Controller
{
    public function index()
    {
        $month = '2020-09';
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $dates = [];
        while ($start->lte($end)) {
        $dates[] = $start->copy();
        $start->addDay();
        }
        dd(count($dates));
        echo "<pre>", print_r($dates), "</pre>";
    }
}
