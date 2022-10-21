<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class HelperController extends Controller
{
    public static function getGpsFromIp() {
        $ip = \Request::ip();
        $data = \Location::get($ip);

        $return = ['ip' => $ip, 'data' => $data];

        return $return;
    }
}
