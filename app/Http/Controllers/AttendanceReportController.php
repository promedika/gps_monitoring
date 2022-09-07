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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
    public function index() {
        $posts = DB::table('post_header')->get();

        $tmp_data = [
            'date' => '2022-09',
            'user_id' => Auth::User()->id
        ];

        $data = $this->getDateTime($tmp_data);

        return view('reports.index', compact('posts','data'));
    }

    public function show(Request $request)
    {
        $postH = DB::table('posts')->where('post_header_id', $request->id)->get();

        return $postH;
    }

    public function getDateTime($params) {
        $return = [];

        $param_year = explode('-',$params['date'])[0];
        $param_month = strlen(explode('-',$params['date'])[1]) == 1 ? '0'.explode('-',$params['date'])[1] : explode('-',$params['date'])[1];

        $month = $params['date'];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $tmp_table_header_2 = [];
        $tmp_table_header_2_no = 1;
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $tmp_table_header_2[] = 'day_'.$tmp_table_header_2_no++;
            $start->addDay();
        }

        $tmp_table_header_1 = ['outlet_user','jabatan_name','outlet_name'];
        $tmp_table_header_3 = ['col_count'];

        $table_header[] = array_merge($tmp_table_header_1,$tmp_table_header_2,$tmp_table_header_3);

        $query = DB::select("
                    SELECT * 
                    FROM posts p  
                    WHERE 1=1 
                    AND p.user_id = '".$params['user_id']."'
                    AND p.imgTaken LIKE '%".$month."%'
                ");

        $tmp_post = [];
        foreach ($query as $k => $v) {
            $tmp_post[$v->outlet_user.'|'.$v->jabatan_name.'|'.$v->outlet_name] = $v;
        }
        unset($query);

        $tmp_visit = [];
        $tmp_visit2 = [];
        $visit = [];
        foreach ($tmp_post as $k_tmp => $v_tmp) {
            $tmp_visit = [
                'outlet_user' => $v_tmp->outlet_user,
                'jabatan_name' => $v_tmp->jabatan_name,
                'outlet_name' => $v_tmp->outlet_name,
            ];

            foreach ($dates as $k_date => $v_date) {
                $k_date_custom = 'day_'.$k_date+1;
                $k_date2 = strlen($k_date+1) == 1 ? '0'.$k_date+1 : $k_date+1;
                $imgTaken = $param_year.'-'.$param_month.'-'.$k_date2;

                $check = DB::select("
                            SELECT * 
                            FROM posts p  
                            WHERE 1=1 
                            AND p.outlet_user = '".$tmp_visit['outlet_user']."'
                            AND p.jabatan_name = '".$tmp_visit['jabatan_name']."'
                            AND p.outlet_name = '".$tmp_visit['outlet_name']."'
                            AND p.imgTaken LIKE '%".$imgTaken."%'
                        ");
                
                $tmp_visit2[$k_date_custom] = count($check);
            }
            
            $visit[] = array_merge($tmp_visit,$tmp_visit2);
        }

        $tmp_return = [];
        foreach ($visit as $keys => $values) {
            $col_count = 0;
            foreach ($values as $k => $v) {
                if ($k == 'outlet_user' || $k == 'jabatan_name' || $k == 'outlet_name') continue;
                $col_count += $v;
            }
            $tmp_arr['col_count'] = $col_count;
            $tmp_return[] = array_merge($values,$tmp_arr);
        }
        
        $return = array_merge($table_header,$tmp_return);

        return $return;
    }
}
