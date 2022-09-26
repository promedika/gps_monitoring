<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Outlet;
use App\Models\UserOutlet;
use DataTables;
use App\Models\PostHeader;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\Session;

class AttendanceReportController extends Controller
{
    public function index()
    {    
        if(Auth::User()->role != 1){
        
        Session::forget('user_id');
        Session::forget('date');
        Session::forget('user_name');

        $users = User::all();
        $posts = DB::table('post_header')->get();

        $tmp_data = [
            'date' => now(),
            'user_id' => null,
            'status' => 'no'
        ];

        $data = $this->getDateTime($tmp_data);

        $dataAtt = $this->getDateTimeAtt($tmp_data);

        return view('reports.index', compact('posts','data','users','tmp_data','dataAtt'));
        }else{
        return redirect('error.404');
        }
    }

    public function show_report(Request $request)
    {
        $user_detail = explode("|",$request->user_fullname);
        $user_id = $user_detail[0];
        $user_fullname = $user_detail[1];

        $this->validate($request, [
            'date' => 'required',
            'user_fullname' => 'required',
        ]);

        $users = User::all();
        $posts = DB::table('post_header')->get();

        $tmp_data = [
            'date' => $request->date,
            'user_id' => $user_id,
            'status' => 'yes'
        ];

        Session::put('user_id', $user_id);
        Session::put('date', $request->date);
        Session::put('user_name', $user_fullname);

        $data = $this->getDateTime($tmp_data);

        $dataAtt = $this->getDateTimeAtt($tmp_data);

        return view('reports.index', compact('posts','data','users','tmp_data','dataAtt'));
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

        $table_body = [];
        $row_count = 0;
        foreach ($visit as $keys => $values) {
            $col_count = 0;
            foreach ($values as $k => $v) {
                if ($k == 'outlet_user' || $k == 'jabatan_name' || $k == 'outlet_name') continue;
                $col_count += $v;
            }
            $tmp_arr['col_count'] = $col_count;
            $table_body[] = array_merge($values,$tmp_arr);
            $row_count += $col_count;
        }

        $tmp_table_footer_2 = [];
        foreach ($tmp_table_header_2 as $k => $v) {
            $tmp_day = str_replace('day_', '', $v);
            $tmp_day = strlen($tmp_day+1) == 1 ? '0'.$tmp_day : $tmp_day;

            $imgTaken = $param_year.'-'.$param_month.'-'.$tmp_day;

            $check = DB::select("
                        SELECT count(*) total 
                        FROM posts p  
                        WHERE 1=1 
                        AND p.user_id = '".$params['user_id']."'
                        AND p.imgTaken LIKE '%".$imgTaken."%'
                    ");
            
            $tmp_table_footer_2[] = $check[0]->total;
        }

        $tmp_table_footer_1 = $tmp_table_header_1;
        $tmp_table_footer_3 = [$row_count];

        $table_footer[] = array_merge($tmp_table_footer_1,$tmp_table_footer_2,$tmp_table_footer_3);
        
        $return = array_merge($table_header,$table_body,$table_footer);
    
        return $return;
    }

    public function getDateTimeAtt($params) {
        $return = [];
        $param_year = explode('-',$params['date'])[0];
        $param_month = strlen(explode('-',$params['date'])[1]) == 1 ? '0'.explode('-',$params['date'])[1] : explode('-',$params['date'])[1];

        $month = $params['date'];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $attDate = ['Tanggal'];
        $attIn = ['Masuk'];
        $attOut = ['Pulang'];
        $attWorkHour = ['Jam_Kerja'];

        $attDate_2 = [];
        $attDate_2_no = 1;

        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $attDate_2[] = 'day_'.$attDate_2_no++;
            $start->addDay();
        }

        // get header clock in/out
        $attDate = array_merge($attDate,$attDate_2);

        // get clock_in_time and clock_out_time
        $not_found = [];
        foreach ($attDate as $k => $v) {
            if ($k == 0) continue;

            $k_date = strlen($k) == 1 ? '0'.$k : $k;
            $imgTaken = $param_year.'-'.$param_month.'-'.$k_date;

            $query = DB::select("
                        SELECT a.clock_in_time, a.clock_out_time,a.work_hour
                        FROM attendances a  
                        WHERE 1=1 
                        AND a.user_id = '".$params['user_id']."'
                        AND a.clock_in_time LIKE '%".$imgTaken."%'
                    ");

            if (count($query) == 0) {
                $not_found[] = $v;
            }

            $tmp_attIn_2 = count($query) > 0 ? $query[0]->clock_in_time : '0000-00-00 00:00:00';
            $tmp_attOut_2 = count($query) > 0  && !is_null($query[0]->clock_out_time) ? $query[0]->clock_out_time : '0000-00-00 00:00:00';
            $attIn_2[] = explode(' ', trim($tmp_attIn_2))[1];
            $attOut_2[] = explode(' ', trim($tmp_attOut_2))[1];
            $tmp_workhour = count($query) > 0 ? $query[0]->work_hour : '0';

            $attWorkHour_2[] = $tmp_workhour;
        }

        $attIn = array_merge($attIn,$attIn_2);
        $attOut = array_merge($attOut,$attOut_2);
        $attWorkHour = array_merge($attWorkHour,$attWorkHour_2);

        $return = count($not_found) == count($dates) ? [$attDate] : [$attDate,$attIn,$attOut,$attWorkHour];
    
        return $return;
    }
    
}
