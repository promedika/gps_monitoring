<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\MarketingAtt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\HelperController;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::User()->role != 1){
            $attendances = Attendance::all();
            }else{
            $attendances = Attendance::where('user_id',Auth::User()->id)->get(); 
            }
        // $attendances = DB::table('attendances')->where('user_id', Auth::User()->id)->get();
        
        return view('attendance.index',compact('attendances'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function uploadAtt(Request $request)
    {
        $type = $request->type;
        $image       = $request->file('file');
        $filename    = time().'_'.$image->hashName();

        $tmp_path = $_FILES["file"]["tmp_name"];

        $unique_id = Auth::User()->id.'_'.date('Ymd');
        $header = DB::table('attendances')->where('id', $unique_id)->get();

        if (count($header) > 0 && $type == 'clock_in_img') {
            return "Anda Sudah Melakukan Clock In Hari ini";
        } elseif (count($header) == 0 && $type == 'clock_out_img') {
            return "Anda Belum Melakukan Clock In Hari ini";
        }

        if (preg_match('/iPhone|iPod|iPad/', $_SERVER['HTTP_USER_AGENT'])) {
            /* This is iOS */
            dd('ios');
            // get detail location from ip address
            $tmpDataIp = HelperController::getGpsFromIp();

            if (!isset($dataIp['data']) || $dataIp['data'] === false || is_null($dataIp['data'])) {
                return "Lokasi Atau Tanggal Tidak Ditemukan  !";
            }

            $imgLocationLatitude = $dataIp['data']->latitude;
            $imgLocationLongitude = $dataIp['data']->longitude;
        }
        else {
            dd('selain ios');
            try {
                exif_read_data($tmp_path);
            } catch (\Throwable $th) {
                return "Lokasi Atau Tanggal Tidak Ditemukan  !";
            }

            //get geolocation of image
            $imgLocation = $this->get_image_location($tmp_path);
            if (!$imgLocation || empty($imgLocation)) {
                return "Lokasi Foto Tidak Ditemukan !";   
            }
            else {
                $imgLocationLatitude = $imgLocation['latitude'];
                $imgLocationLongitude = $imgLocation['longitude'];
            }
        }

        $imgLoc = !empty($imgLocation) ? $imgLocationLatitude. "|" .$imgLocationLongitude : 'Geotags not found';

        // get detail location from image
        $detailImageLocation = '';
        $detailImagePlaceId = '';
        $imageLocIp = HelperController::getGeoLocation($imgLocationLatitude,$imgLocationLongitude);
        $detailImageLocation = $imageLocIp['detail_location'];
        $detailImagePlaceId = $imageLocIp['place_id'];

        // get detail location from ip address
        $dataIp = HelperController::getGpsFromIp();
        $ip_address = $dataIp['ip'];
        $detailDeviceLocation = '';
        $detailDevicePlaceId = '';
        if ($dataIp['data'] !== false) {
            $deviceLocIp = HelperController::getGeoLocation($dataIp['data']->latitude,$dataIp['data']->longitude);
            $detailDeviceLocation = $deviceLocIp['detail_location'];
            $detailDevicePlaceId = $deviceLocIp['place_id'];
        }

        // validate fake gps from image and ip address
        $allowed_hosts = ['::1', 'localhost'];
        $noteFakeGps = 'No';
        if ($detailImagePlaceId != $detailDevicePlaceId) {
            if (!in_array($_SERVER['HTTP_HOST'], $allowed_hosts)) {
                $noteFakeGps = 'Yes';
            }
        }
        
        // get image taken date
        $imgDate = exif_read_data($tmp_path);
        $imgTaken = !empty($imgDate['DateTimeOriginal']) ? $imgDate['DateTimeOriginal'] : null;

        if(date('Y-m-d') != date('Y-m-d', strtotime($imgTaken))) {
            return "Tanggal Foto Tidak Sesuai !";
        }else{
                
            $ogDate = date_create(date('Y-m-d H:i:s',strtotime($imgDate['DateTimeOriginal'])));
            $tfDate = date_create(date('Y-m-d H:i:s',$imgDate['FileDateTime']));
            $now = date_create(date('Y-m-d H:i:s'));
            
            $difDate = date_diff($ogDate,$now);
            
            if($difDate->h > 0 || $difDate->i > 0 ){
                return 'Jam Foto Tidak Sesuai !';
            }

            $difDate = date_diff($tfDate,$ogDate);
            
            if($difDate->i > 1){
                return 'Request Time Out !';
            }
        }

        // declare full path and filename
        $target_file = public_path('/assets/img/'.$type.'/'.$filename);
        
        // move file upload to storage
        $image->move(public_path('/assets/img/'.$type.'/'), $filename);

        $image_resize = Image::make($target_file)->orientate();           
        $image_resize->resize(250, 250);

        // $image_resize->resize(250, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        $image_resize->save();

        $unique_id = Auth::User()->id.'_'.date('Ymd');
        $header = DB::table('attendances')
        ->where('id', $unique_id)
            ->get();
        
        if (count($header) == 0) {
            DB::table('attendances')->insert([
                'id' => $unique_id,
                'user_id' => Auth::User()->id,
                'user_fullname' => Auth::User()->first_name." ".Auth::User()->last_name,
                'clock_in_img' => $filename,
                'clock_in_time' => $imgTaken,
                'clock_in_loc' => $imgLoc,
                'work_hour' => 0,
                'status' => 'kurang dari jam kerja',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'ip_address_clock_in' => $ip_address,
                'fake_gps_clock_in' => $noteFakeGps,
                'detail_location_clock_in' => $detailDeviceLocation,
                'detail_location_image_clock_in' => $detailImageLocation
            ]);

            return "Clock In Berhasil !";

            } else {
            $postdate = DB::table('attendances')
                ->where('id',$unique_id) 
                ->get();
            foreach ($postdate as $key => $value) {
                $clockIn = strtotime($value->clock_in_time);
                $clockOut = strtotime($imgTaken);;
            }
                
            $start = date_create(date('Y-m-d H:i:s',$clockIn));
            $end    = date_create(date('Y-m-d H:i:s',$clockOut));
            
            $work_hour = date_diff($start,$end);
            $status = $work_hour->h < 8 ? 'kurang dari jam kerja' : 'sesuai'; 

            DB::table('attendances')
            ->where('id',$unique_id)
            ->update([
                'clock_out_img' => $filename,
                'clock_out_time' => $imgTaken,
                'clock_out_loc' => $imgLoc,
                'work_hour' => $work_hour->h.':'.$work_hour->i.':'.$work_hour->s,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
                'ip_address_clock_out' => $ip_address,
                'fake_gps_clock_out' => $noteFakeGps,
                'detail_location_clock_out' => $detailDeviceLocation,
                'detail_location_image_clock_out' => $detailImageLocation
            ]);

            return "Clock Out Berhasil !";
            }
    }

    public function gps2Num($coordPart){
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
        return 0;
        if(count($parts) == 1)
        return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

        /**
     * get_image_location
     * Returns an array of latitude and longitude from the Image file
     * @param $image file path
     * @return multitype:array|boolean
     */
    public function get_image_location($image = ''){
        $exif = exif_read_data($image, 0, true);
        
        if($exif
         && isset($exif['GPS']['GPSLatitudeRef']) 
         && isset($exif['GPS']['GPSLatitude'])
         && isset($exif['GPS']['GPSLongitudeRef'])
         && isset($exif['GPS']['GPSLongitude'])
        ){
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude    = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude   = $exif['GPS']['GPSLongitude'];
            
            $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;
            
            $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;
            
            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
            
            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return false;
        }
    }
}
