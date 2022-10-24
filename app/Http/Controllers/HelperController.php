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
