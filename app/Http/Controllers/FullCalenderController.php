<?php

  

namespace App\Http\Controllers;

  

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

  

class FullCalenderController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index(Request $request)

    {

  

        if($request->ajax()) {



            //  $data = Post::whereDate('start', '>=', $request->imgTaken)

            //            ->whereDate('end',   '<=', $request->imgTaken)

            //            ->get(['id', 'user_fullname title', 'imgTaken start', 'imgTaken end']);

        $data = array();
        $posts = Post::all();
        
        foreach($posts as $post) {
            // if (Auth::User()->user_id !=$post->user_id) continue;
            $data[] = [
                'title' => $post->outlet_name,
                'start' => $post->imgTaken,
                'end' => $post->imgTaken,
            ];
        }
            
  

             return response()->json($data);

        }

  

        return view('fullcalender.fullcalender');

    }

 

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function ajax(Request $request)

    {

 
        
        switch ($request->type) {

           case 'add':

              $event = Event::create([

                  'title' => $request->title,

                  'start' => $request->start." ".date("H:i:s"),

                  'end' => $request->end." ".date("H:i:s"),

              ]);

 

              return response()->json($event);

             break;

  

           case 'update':

              $event = Event::find($request->id)->update([

                  'title' => $request->title,

                  'start' => $request->start,

                  'end' => $request->end,

              ]);

 

              return response()->json($event);

             break;

  

           case 'delete':

              $event = Event::find($request->id)->delete();

  

              return response()->json($event);

             break;

             

           default:

             # code...

             break;

        }

    }



}