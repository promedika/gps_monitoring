<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class HelperController extends Controller
{
    public static function getGpsFromIp() {
        // $ip = \Request::ip();
        $ip = $this->getIpAddress();

        $data = \Location::get($ip);

        $return = ['ip' => $ip, 'data' => $data];
        dd($return,$_SERVER);

        return $return;
    }

    /**
     * Gets IP address.
     */
    public static function getIpAddress() {
        $ipAddress = '';
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (! empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (! empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (! empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
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
