<?php

namespace App\Http\Controllers;

use App\Models\MarketingAtt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;


class MarketingAttController extends Controller
{
    public function index()
    {
        
        //get posts
        if (Auth::User()->role == 0){
        $posts = MarketingAtt::all();
        }else{
        $posts = MarketingAtt::where('user_id',Auth::User()->id)->get(); 
        }
        //render view with posts
        return view('marketingatt.index', compact('posts'));
    }

    public function clock_in(Request $request)
    {
        $this->validate($request, [
            'clock_in_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPG',
        ]);
        
        if ($request->hasFile('clock_in_img')) {
            
            $image       = $request->file('clock_in_img');
            $filename    = time().'_'.$image->hashName();

            $image->storeAs('public/clock_in', $filename);
            // $image->uploads('public/posts', $filename);

            // declare full path and filename
            $path = URL::to('/storage/clock_in').'/'.$filename;
            
            try {
                exif_read_data($path);
            } catch (\Throwable $th) {
                Storage::delete('/public/clock_in/'.$filename);
                return redirect()->back()->with('message', 'Lokasi Gambar Tidak Ditemukan !');
            }
            
            //get geolocation of image
            $imgLocation = $this->get_image_location($path);
            $imgLoc = !empty($imgLocation) ? $imgLocation['latitude']. "|" .$imgLocation['longitude'] : 'Geotags not found';
            
            // get image taken date
            $imgDate = exif_read_data($path);
            $imgTaken = !empty($imgDate['DateTimeOriginal']) ? $imgDate['DateTimeOriginal'] : null;

            if(date('Y-m-d') != date('Y-m-d', strtotime($imgTaken))) {
                Storage::delete('/public/clock_in/'.$filename);
                return redirect()->back()->with('message', 'Tanggal Foto Tidak Sesuai !');
            }

            $image_resize = Image::make($image->getRealPath())->orientate();              
            $image_resize->resize(250, 250,);
            $image_resize->stream();

            Storage::disk('local')->put('public/clock_in'.'/'.$filename, $image_resize, 'public');
        };

        $unique_id = Auth::User()->id.'_'.date('Ymd');
        
        MarketingAtt::create([
            'id' => $unique_id,
            'clock_in' =>  $filename,
            'user_id'   => Auth::User()->id,
            'user_fullname' => Auth::User()->first_name." ".Auth::User()->last_name,
            'clock_in_Loc' => $imgLoc,
            'clock_in_time'=> $imgTaken,
        ]);
    }
}
