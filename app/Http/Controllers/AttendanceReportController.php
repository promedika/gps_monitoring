<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Outlet;
use App\Models\UserOutlet;
use DataTables;
use App\Models\PostHeader;
use DB;

class AttendanceReportController extends Controller
{
    public function index(){

    // $posts = PostHeader::all();
    $posts = DB::table('post_header')->get();

    return view('reports.index', compact('posts'));
    }

    // $users = User::All();
    //     $posts = Post::All();

    //     $data_posts = [];
    //     $data = [];
    //     foreach ($users as $k => $v) {
    //         $tmp_user = $v->id;
    //         foreach ($posts as $key => $value) {
    //             // if ($tmp_user != $value->user_id) continue;

    //             // update logic work hour here..
    //             $work_hour = 8;

    //             $data_posts[$tmp_user] = [
    //                 'user_id' => $value->user_id,
    //                 'user_fullname' => $value->user_fullname,
    //                 'imgTaken' => date('d-m-Y',strtotime($value->imgTaken)),
    //                 'work_hour' => $work_hour,
    //                 'status' => $work_hour < 8 ? 'Tidak sesuai jam kerja' : 'sesuai jam kerja'
    //             ];
    //         }
    //         $data[] = $data_posts; 
    //     }

    //     dd($data);
    // }

}
