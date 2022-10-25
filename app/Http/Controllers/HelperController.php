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
        // dd($return,$_SERVER);

        return $return;
    }

    /**
     * Gets IP address.
     */
    // public static function getGpsFromIp() {
    //     $ip = '';
    //     if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
    //         // to get shared ISP IP address
    //         $ip = $_SERVER['HTTP_CLIENT_IP'];
    //     } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //         // check for IPs passing through proxy servers
    //         // check if multiple IP addresses are set and take the first one
    //         $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    //         foreach ($ipList as $ip) {
    //             if (! empty($ip)) {
    //                 // if you prefer, you can check for valid IP address here
    //                 $ip = $ip;
    //                 break;
    //             }
    //         }
    //     } else if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
    //         $ip = $_SERVER['HTTP_X_FORWARDED'];
    //     } else if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
    //         $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    //     } else if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
    //         $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    //     } else if (! empty($_SERVER['HTTP_FORWARDED'])) {
    //         $ip = $_SERVER['HTTP_FORWARDED'];
    //     } else if (! empty($_SERVER['REMOTE_ADDR'])) {
    //         $ip = $_SERVER['REMOTE_ADDR'];
    //     }
        
    //     $ip = '120.188.7.30';
    //     $data = \Location::get($ip);

    //     $return = ['ip' => $ip, 'data' => $data];
    //     dd($return,$_SERVER);

    //     return $return;
    // }

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
