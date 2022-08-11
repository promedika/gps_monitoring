<?php

  

namespace App\Http\Controllers;

  

use Illuminate\Http\Request;
use App\Models\Post;
use Response;

  

class FullCalenderDDController extends Controller
{
    public function index()
    {
        $events = array();
        $posts = Post::all();
        foreach($posts as $post) {
            $events[] = [
                'title' => $post->user_fullname,
                'start' => $post->imgTaken,
                'end'   => $post->imgTaken,
                'location' => $post->imgLoc,
                'Outlet' => $post->outlet_name,
                'PIC'  => $post->outlet_user,    
            ];
        }
        // $events = json_encode($events);
         return response()->json($events);
        // return Response::view('fullcalender.fullcalender')->json($events);
        // return view('fullcalender.fullcalender', ['event' => $events]);
    }
}