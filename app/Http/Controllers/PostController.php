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
        if (Auth::User()->role == 0){
        $posts = Post::latest()->paginate(5);
        }else{
        $posts = Post::where('user_id',Auth::User()->id)->latest()->paginate(5); 
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
        $useroutlets = UserOutlet::get(["name", "outlet_id"]);
        return view('posts.create', ['outlets'=>$outlets,'useroutlets'=>$useroutlets]);
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
           
            $image->storeAs('public/posts', $filename);

            // declare full path and filename
            $path = URL::to('/storage/posts').'/'.$filename;

            //get geolocation of image
            $imgLocation = $this->get_image_location($path);
            $imgLoc = !empty($imgLocation) ? $imgLocation['latitude']. "|" .$imgLocation['longitude'] : 'Geotags not found';
            
            //get image taken date
            $imgDate = exif_read_data($path);
            $imgTaken = !empty($imgDate['DateTimeOriginal']) ? $imgDate['DateTimeOriginal'] : null;
        
            // $image_resize = Image::make($image->getRealPath());              
            // $image_resize->resize(100, 100);
            // $image_resize->save(public_path('images/ServiceImages/' .$filename));
            // $image_resize->storeAs('/public/posts', $filename);
            // $image_resize->save(public_path('posts/' .$filename));
        
        };
        
        //create post
        Post::create([
            'image' =>  $filename,
            'outlet_name' =>  $request->outlet_name,
            'outlet_user'   =>  $request->useroutlet_name,
            'user_id'   => Auth::User()->id,
            'user_fullname' => Auth::User()->first_name." ".Auth::User()->last_name,
            'imgLoc' => $imgLoc,
            'imgTaken'=> $imgTaken,
        ]);
        


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
        if($exif && isset($exif['GPS'])){
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
