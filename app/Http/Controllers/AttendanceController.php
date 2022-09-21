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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function startWork(Request $request)
    // {
    //     $attendance = new Attendance();
    //     $attendance->date = Date('Y-m-d');
    //     $attendance->start_time = Date('H:i:s');
    //     $attendance->user_id = Auth::User()->id;
    //     $attendance->save();
    //     return redirect(route('dashboard.attendances.index'));
    // }

    // public function finishWork(Request $request)
    // {
    //     $currentDate = Date('Y-m-d');
    //     $attendance = Attendance::whereDate('date',$currentDate)->where('user_id',Auth::User()->id)->first();
    //     $attendance->end_time = Date('H:i:s');
    //     $attendance->save();
    //     return redirect(route('dashboard.attendances.index')); 
    // }

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
        $imgLoc = !empty($imgLocation) ? $imgLocation['latitude']. "|" .$imgLocation['longitude'] : 'Geotags not found';
        
        // get image taken date
        $imgDate = exif_read_data($tmp_path);
        $imgTaken = !empty($imgDate['DateTimeOriginal']) ? $imgDate['DateTimeOriginal'] : null;

        if(date('Y-m-d') != date('Y-m-d', strtotime($imgTaken))) {
            return "Tanggal Foto Tidak Sesuai !";
        }else{
                
            $ogDate = date_create(date('Y-m-d H:i:s',strtotime($imgDate['DateTimeOriginal'])));
            $tfDate = date_create(date('Y-m-d H:i:s',$imgDate['FileDateTime']));
            
            $difDate = date_diff($tfDate,$ogDate);
            if($difDate->s > 60){
                return redirect()->back()->with('message', 'Jam Foto Tidak Sesuai !');
            }
        }

        // declare full path and filename
        $target_file = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$filename);
        
        // move file upload to storage
        move_uploaded_file($tmp_path, $target_file);

        $image_resize = Image::make($target_file)->orientate();           
        $image_resize->resize(250, 250,);
        $image_resize->stream();

        Storage::disk('local')->put('public'.'/'.$type.'/'.$filename, $image_resize, 'public');

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
                'updated_at' => date('Y-m-d H:i:s')
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
                'updated_at' => date('Y-m-d H:i:s')
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
