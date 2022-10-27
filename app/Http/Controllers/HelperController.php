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

    public static function getGeoLocation($latitude,$longitude){
        if (!empty($latitude) && !empty($longitude)) {
            //Send request and receive json data by address
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.env('GEOCODE_KEY');
            $geocodeFromLatLong = file_get_contents($url);
            $output = json_decode($geocodeFromLatLong);

            $data = [
                'plus_code' => $output->plus_code,
                'results' => $output->results[0],
                'status' => $output->status
            ];

            $global_code = substr(trim($data['plus_code']->global_code), 0, 6);

            //Get address from json data
            $global_code = ($status=="OK") ? $global_code : '';

            //Return place_id of the given latitude and longitude
            if (!empty($global_code)) {
                $return = [
                    'place_id' => $global_code,
                    'detail_location' => json_encode($data)
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
