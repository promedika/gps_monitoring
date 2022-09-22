<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Models\Outlet;
use App\Models\UserOutlet;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use URL;
use DataTables;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        
        //get posts
        if (Auth::User()->role != 1){
        $posts = Post::all();
        }else{
        $posts = Post::where('user_id',Auth::User()->id)->get(); 
        }
        
        //render view with posts
        return view('posts.index', compact('posts'));
    }

    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        $outlets = Outlet::get(["name", "id"]);
        return view('posts.create', ['outlets'=>$outlets,]);
    }

    /**
     * store
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        
        //validate form
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPG',
            'outlet_name' => 'required',
            'useroutlet_name'   => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            
            $image       = $request->file('image');
            $filename    = time().'_'.$image->hashName();
           
            $tmp_path = $_FILES["image"]["tmp_name"];
            
            try {
                exif_read_data($tmp_path);
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Lokasi Atau Tanggal Tidak Ditemukan !');
            }
            
            //get geolocation of image
            $imgLocation = $this->get_image_location($tmp_path);
            
            if (!$imgLocation || empty($imgLocation)) {
                
                return redirect()->back()->with('message', "Lokasi Foto Tidak Ditemukan !");   
            }
            $imgLoc = !empty($imgLocation) ? $imgLocation['latitude']. "|" .$imgLocation['longitude'] : 'Geotags not found';
            
            // get image taken date
            $imgDate = exif_read_data($tmp_path);
            $imgTaken = !empty($imgDate['DateTimeOriginal']) ? $imgDate['DateTimeOriginal'] : null;
            

            if(date('Y-m-d') != date('Y-m-d', strtotime($imgTaken))) {
                return redirect()->back()->with('message', 'Tanggal Foto Tidak Sesuai !');
            }else{
                
                $ogDate = date_create(date('Y-m-d H:i:s',strtotime($imgDate['DateTimeOriginal'])));
                $tfDate = date_create(date('Y-m-d H:i:s',$imgDate['FileDateTime']));
                
                $difDate = date_diff($tfDate,$ogDate);
                if($difDate->s > 60){
                    return redirect()->back()->with('message', 'Jam Foto Tidak Sesuai !');
                }
            }

            // declare full path and filename
            $target_file = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'posts'.DIRECTORY_SEPARATOR.$filename);

            // move file upload to storage
            move_uploaded_file($tmp_path, $target_file);

            $image_resize = Image::make($target_file)->orientate();           
            $image_resize->resize(250, 250,);
            $image_resize->stream();

            Storage::disk('local')->put('public/posts'.'/'.$filename, $image_resize, 'public');
        };
        $outlet = explode('|',$request->outlet_name);
        $outlet_id = $outlet[0];
        $outlet_name = $outlet[1];

        $outlet_user = explode('|',$request->useroutlet_name);
        $outlet_user_id = $outlet_user[0];
        $outlet_user_name = $outlet_user[1];

        $jabatan = explode('|',$request->jabatan_name);
        $jabatan_id = $jabatan[0];
        $jabatan_name = $jabatan[1];
        
        $unique_id = Auth::User()->id.'_'.date('Ymd');
        // create post
        Post::create([
            'image' =>  $filename,
            'outlet_name_id' => $outlet_id,
            'outlet_name' =>  $outlet_name,
            'outlet_user_id' => $outlet_user_id,
            'outlet_user'   =>  $outlet_user_name,
            'user_id'   => Auth::User()->id,
            'user_fullname' => Auth::User()->first_name." ".Auth::User()->last_name,
            'imgLoc' => $imgLoc,
            'imgTaken'=> $imgTaken,
            'post_header_id' => $unique_id,
            'jabatan_id' => $jabatan_id,
            'jabatan_name' => $jabatan_name,
            'activity' => $request->activity,

        ]);

        $header = DB::table('post_header')
        ->where('user_id', Auth::User()->id)
        ->where('created_at', date('Y-m-d').' 00:00:00')
            ->get();
        
        if (count($header) == 0) {
            DB::table('post_header')->insert([
                'id' => $unique_id,
                'user_id' => Auth::User()->id,
                'user_fullname' => Auth::User()->first_name." ".Auth::User()->last_name,
                'work_hour' => 0,
                'status' => 'kurang dari jam kerja',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            //hitung jam kerja dari table post
            $postdate = DB::table('posts')
            ->where('user_id', Auth::User()->id)
            ->orWhere('imgTaken','LIKE','%'.date('Y-m-d').'%')
            ->where('post_header_id', $unique_id) 
                ->get();

            $tmpDate = [];
                foreach ($postdate as $key => $value) {
                    $tmpDate[] = strtotime($value->imgTaken);
                }
                sort($tmpDate);
                
            $start = date_create(date('Y-m-d H:i:s',$tmpDate[0]));
            $end    = date_create(date('Y-m-d H:i:s',$tmpDate[count($tmpDate)-1]));
            
            $work_hour = date_diff($start,$end);
            $status = $work_hour->h < 8 ? 'kurang dari jam kerja' : 'sesuai';
            DB::table('post_header')
            ->where('user_id', Auth::User()->id)
            ->where('created_at', date('Y-m-d').' 00:00:00')
            ->update([
                'work_hour' => $work_hour->h.':'.$work_hour->i.':'.$work_hour->s,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        


        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * edit
     * 
     * @param mixed $post
     * @return void
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }   

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $post
     * @return void
     */
    public  function update(Request $request, Post $post)
    {
        //validate form
        $this->validate($request, [
            'image' =>  'image|mimes:jpeg,png,jpg,gif,svg',
            'outlet_name' => 'required',
            'useroutlet_name'   =>  'required'
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('/public/posts', $image->hasName());

            //delete old image
            Storage::delete('/public/posts/'.$post->image);

            //update post with new image
            $post->update([
                'image' => $image->hashName(),
                'outlet_name' =>  $request->outlet_name,
                'outlet_user'   =>  $request->useroutlet_name,
            ]);
        } else {

            //update post without image
            $post->update([
                'outlet_name' =>  $request->outlet_name,
                'useroutlet_name'   =>  $request->outlet_user,
            ]);
        }

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     * 
     * @param mixed $post
     * @return void
     */
    public function destroy(Post $post)
    {
        //delete image
        Storage::delete('/public/posts/'.$post->image);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
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

    public function show(Request $request)
    {
        //
    }

}
