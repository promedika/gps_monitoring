<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class HelperController extends Controller
{
    // public static function getGpsFromIp() {
    //     $ip = \Request::ip();
    //     $data = \Location::get($ip);

    //     $return = ['ip' => $ip, 'data' => $data];

    //     return $return;
    // }

    // Function to get the client IP address
    public static function getGpsFromIp() {
        $ip = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ip = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ip = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ip = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ip = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ip = getenv('REMOTE_ADDR');
        else
            $ip = 'UNKNOWN';

        $data = \Location::get($ip);

        $return = ['ip' => $ip, 'data' => $data];
        dd($return);

        return $return;
    }

    public static function getGeoLocation($latitude,$longitude){
        if (!empty($latitude) && !empty($longitude)) {
            //Send request and receive json data by address
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.env('GEOCODE_KEY');
            $geocodeFromLatLong = file_get_contents($url);
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;

            //Get address from json data
            $place_id = ($status=="OK") ? $output->results[0]->place_id : '';

            //Return place_id of the given latitude and longitude
            if (!empty($place_id)) {
                $return = [
                    'place_id' => $place_id,
                    'detail_location' => json_encode($output)
                ];
                return $return;
            } else {
                return false;
            }
        } else {
         return false;   
        }
    }
}
