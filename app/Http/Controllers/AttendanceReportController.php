<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttendanceReportController extends Controller
{
    public function index()
    {
        if (Auth::User()->role == 0 || Auth::User()->role == 2) {
            Session::forget('user_id');
            Session::forget('date');
            Session::forget('user_name');

            $users = User::all();
            $posts = DB::table('post_header')->get();

            $tmp_data = [
                'date' => now(),
                'user_id' => null,
                'status' => 'no',
            ];

            $data = $this->getDateTime($tmp_data);

            $dataAtt = $this->getDateTimeAtt($tmp_data);

            return view('reports.index', compact('posts', 'data', 'users', 'tmp_data', 'dataAtt'));
        } else {
            return redirect('error.404');
        }
    }
    public function absensi()
    {
        $data = DB::table('attedances')
            ->join('users', 'users.id', '=', 'attedances.user_id')
            ->select('attedances' . 'clock_in_time', 'clock_in_out', 'work_hour', 'users' . 'nik', 'department')
            ->get();
        // dd($data);
        return view('reports.absensi', compact('attedances', 'users'));
    }

    public function show_report(Request $request)
    {
        $user_detail = explode("|", $request->user_fullname);
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
            'status' => 'yes',
        ];

        Session::put('user_id', $user_id);
        Session::put('date', $request->date);
        Session::put('user_name', $user_fullname);

        $data = $this->getDateTime($tmp_data);

        $dataAtt = $this->getDateTimeAtt($tmp_data);

        return view('reports.index', compact('posts', 'data', 'users', 'tmp_data', 'dataAtt'));
    }

    public function show_absensi()
    {
        $data = DB::table('attedances')
            ->join('users', 'users.id', '=', 'attedances.user_id')
            ->select('attedances' . 'clock_in_time', 'clock_in_out', 'work_hour', 'users' . 'nik', 'department')
            ->get();
        // dd($data);
        return view('reports.absensi', compact('attedances', 'posts'));
    }

    public function getDateTime($params)
    {
        $return = [];
        $param_year = explode('-', $params['date'])[0];
        $param_month = strlen(explode('-', $params['date'])[1]) == 1 ? '0' . explode('-', $params['date'])[1] : explode('-', $params['date'])[1];

        $month = $params['date'];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $tmp_table_header_2 = [];
        $tmp_table_header_2_no = 1;
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $tmp_table_header_2[] = 'day_' . $tmp_table_header_2_no++;
            $start->addDay();
        }

        $tmp_table_header_1 = ['outlet_user', 'jabatan_name', 'outlet_name'];
        $tmp_table_header_3 = ['col_count'];

        $table_header[] = array_merge($tmp_table_header_1, $tmp_table_header_2, $tmp_table_header_3);

        $query = DB::select("
                    SELECT *
                    FROM posts p
                    WHERE 1=1
                    AND p.user_id = '" . $params['user_id'] . "'
                    AND p.imgTaken LIKE '%" . $month . "%'
                ");

        $tmp_post = [];
        foreach ($query as $k => $v) {
            $tmp_post[$v->outlet_user . '|' . $v->jabatan_name . '|' . $v->outlet_name] = $v;
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
                $k_date_custom = 'day_' . $k_date + 1;
                $k_date2 = strlen($k_date + 1) == 1 ? '0' . $k_date + 1 : $k_date + 1;
                $imgTaken = $param_year . '-' . $param_month . '-' . $k_date2;

                $check = DB::select("
                            SELECT *
                            FROM posts p
                            WHERE 1=1
                            AND p.outlet_user = '" . $tmp_visit['outlet_user'] . "'
                            AND p.jabatan_name = '" . $tmp_visit['jabatan_name'] . "'
                            AND p.outlet_name = '" . $tmp_visit['outlet_name'] . "'
                            AND p.imgTaken LIKE '%" . $imgTaken . "%'
                            AND p.user_id = '" . $params['user_id'] . "'
                        ");

                $tmp_visit2[$k_date_custom] = count($check);
            }

            $visit[] = array_merge($tmp_visit, $tmp_visit2);
        }

        $table_body = [];
        $row_count = 0;
        foreach ($visit as $keys => $values) {
            $col_count = 0;
            foreach ($values as $k => $v) {
                if ($k == 'outlet_user' || $k == 'jabatan_name' || $k == 'outlet_name') {
                    continue;
                }
                $col_count += $v;
            }
            $tmp_arr['col_count'] = $col_count;
            $table_body[] = array_merge($values, $tmp_arr);
            $row_count += $col_count;
        }

        $tmp_table_footer_2 = [];
        foreach ($tmp_table_header_2 as $k => $v) {
            $tmp_day = str_replace('day_', '', $v);
            $tmp_day = strlen($tmp_day + 1) == 1 ? '0' . $tmp_day : $tmp_day;

            $imgTaken = $param_year . '-' . $param_month . '-' . $tmp_day;

            $check = DB::select("
                        SELECT count(*) total
                        FROM posts p
                        WHERE 1=1
                        AND p.user_id = '" . $params['user_id'] . "'
                        AND p.imgTaken LIKE '%" . date('Y-m-d',strtotime($imgTaken)) . "%'
                    ");

            $tmp_table_footer_2[] = $check[0]->total;
        }

        $tmp_table_footer_1 = $tmp_table_header_1;
        $tmp_table_footer_3 = [$row_count];

        $table_footer[] = array_merge($tmp_table_footer_1, $tmp_table_footer_2, $tmp_table_footer_3);

        $return = array_merge($table_header, $table_body, $table_footer);

        return $return;
    }

    public function getDateTimeAtt($params)
    {
        $return = [];
        $param_year = explode('-', $params['date'])[0];
        $param_month = strlen(explode('-', $params['date'])[1]) == 1 ? '0' . explode('-', $params['date'])[1] : explode('-', $params['date'])[1];

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
            $attDate_2[] = 'day_' . $attDate_2_no++;
            $start->addDay();
        }

        // get header clock in/out
        $attDate = array_merge($attDate, $attDate_2);

        // get clock_in_time and clock_out_time
        $not_found = [];
        foreach ($attDate as $k => $v) {
            if ($k == 0) {
                continue;
            }

            $k_date = strlen($k) == 1 ? '0' . $k : $k;
            $imgTaken = $param_year . '-' . $param_month . '-' . $k_date;
            // $imgTaken = $param_year . '-' . $param_month;

            $query = DB::select("
                        SELECT a.clock_in_time, a.clock_out_time,a.work_hour
                        FROM attendances a
                        WHERE 1=1
                        AND a.user_id = '" . $params['user_id'] . "'
                        AND a.clock_in_time LIKE '%" . $imgTaken . "%'
                        -- AND a.clock_out_time LIKE '%" . $imgTaken . "%'

                    ");

            if (count($query) == 0) {
                $not_found[] = $v;
            }

            $tmp_attIn_2 = count($query) > 0 ? $query[0]->clock_in_time : '0000-00-00 00:00:00';
            $tmp_attOut_2 = count($query) > 0 && !is_null($query[0]->clock_out_time) ? $query[0]->clock_out_time : '0000-00-00 00:00:00';
            $attIn_2[] = explode(' ', trim($tmp_attIn_2))[1];
            $attOut_2[] = explode(' ', trim($tmp_attOut_2))[1];
            $tmp_workhour = count($query) > 0 ? $query[0]->work_hour : '0';

            $attWorkHour_2[] = $tmp_workhour;
        }

        $attIn = array_merge($attIn, $attIn_2);
        $attOut = array_merge($attOut, $attOut_2);
        $attWorkHour = array_merge($attWorkHour, $attWorkHour_2);

        $return = count($not_found) == count($dates) ? [$attDate] : [$attDate, $attIn, $attOut, $attWorkHour];

        return $return;
    }

    public function reportsVisit(Request $request)
    {
        if (Auth::User()->department == 1 || Auth::User()->department == 2 || Auth::User()->department == 3 || Auth::User()->department == 4 || Auth::User()->department == 5) {
            return redirect('/');
        }
        
        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::forget('first_date');
        Session::forget('end_date');
        $thn_awal = date('Y');
        $bln_awal = date('m');

        $thn_akhir = date('Y');
        $bln_akhir = date('m');

        //get posts
        $posts = Post::whereBetween('created_at', [$thn_awal.'-'.$bln_awal.'-01', $thn_awal.'-'.$bln_awal.'-31'])->get();

        foreach ($posts as $k => $v) {
            //get users
            $user = User::find($v->user_id);

            if (Auth::User()->department != 0) {
                if (Auth::User()->department != $user->department) {
                    // continue;
                }
            }

            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }
            $v->department = $department;

            $imgTaken = is_null($v->imgTaken) ? '-' : $v->imgTaken;
            $v->hari = Carbon::parse(explode(' ', $imgTaken)[0])->translatedFormat('l');
        }

        //render view with posts
        return view('reports.kunjungan', compact('posts'));
    }

    public function reportsVisitFilter(Request $request)
    {
        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::put('first_date', $request->first_date);
        Session::put('end_date', $request->end_date);

        $thn_awal = explode('-', $first_date)[0];
        $bln_awal = explode('-', $first_date)[1];

        $thn_akhir = explode('-', $end_date)[0];
        $bln_akhir = explode('-', $end_date)[1];

        //get posts
        $posts = Post::whereBetween('created_at', [$first_date, $end_date])->get();

        foreach ($posts as $k => $v) {
            //get users
            $user = User::find($v->user_id);

            if (Auth::User()->department != 0) {
                if (Auth::User()->department != $user->department) {
                    // continue;
                }
            }

            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }
            $v->department = $department;

            $imgTaken = is_null($v->imgTaken) ? '-' : $v->imgTaken;
            $v->hari = Carbon::parse(explode(' ', $imgTaken)[0])->translatedFormat('l');
        }

        //render view with posts
        return view('reports.kunjungan', compact('posts'));
    }

    public function reportsAbsensi(Request $request)
    {
        if (Auth::User()->department == 1 || Auth::User()->department == 2 || Auth::User()->department == 3 || Auth::User()->department == 4 || Auth::User()->department == 5) {
            return redirect('/');
        }

        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::forget('first_date');
        Session::forget('end_date');
        $thn_awal = date('Y');
        $bln_awal = date('m');

        $thn_akhir = date('Y');
        $bln_akhir = date('m');

        $attendances = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select('attendances.id', 'attendances.user_fullname', 'attendances.clock_in_time', 'attendances.clock_in_img', 'attendances.clock_in_loc', 'attendances.created_at', 'attendances.updated_at', 'attendances.work_hour', 'attendances.user_id', 'users.nik', 'users.department')
            ->where('attendances.created_at', '>=', $thn_awal.'-'.$bln_awal.'-01')
            ->where('attendances.created_at', '<=', $thn_awal.'-'.$bln_awal.'-31');

        if (Auth::User()->department != 0 || Auth::User()->department != 6) {
            if (Auth::User()->role == 2) {
                $attendances = $attendances->where('users.department', 1);
            } elseif (Auth::User()->role == 4) {
                $attendances = $attendances->whereIn('users.department', [2, 3, 4, 5]);
            }
        }

        $attendances = $attendances->get();
        foreach ($attendances as $k => $v) {
            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }

            $v->department = $department;

            $created_at = is_null($v->created_at) ? '-' : $v->created_at;
            $updated_at = is_null($v->updated_at) ? '-' : $v->updated_at;
            $v->hari = Carbon::parse(explode(' ', $created_at)[0])->translatedFormat('l');
            $v->hari = Carbon::parse(explode(' ', $updated_at)[0])->translatedFormat('l');
        }

        return view('reports.absensi', compact('attendances'));
    }

    public function reportsAbsensiFilter(Request $request)
    {
        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::put('first_date', $request->first_date);
        Session::put('end_date', $request->end_date);

        $thn_awal = explode('-', $first_date)[0];
        $bln_awal = explode('-', $first_date)[1];

        $thn_akhir = explode('-', $end_date)[0];
        $bln_akhir = explode('-', $end_date)[1];

        $attendances = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select('attendances.id', 'attendances.user_fullname', 'attendances.clock_in_time', 'attendances.clock_in_img', 'attendances.clock_in_loc', 'attendances.created_at', 'attendances.updated_at', 'attendances.work_hour', 'attendances.user_id', 'users.nik', 'users.department')
            ->whereBetween('attendances.created_at', [$first_date, $end_date]);

        if (Auth::User()->department != 0 || Auth::User()->department != 6) {
            if (Auth::User()->role == 2) {
                $attendances = $attendances->where('users.department', 1);
            } elseif (Auth::User()->role == 4) {
                $attendances = $attendances->whereIn('users.department', [2, 3, 4, 5]);
            }
        }

        $attendances = $attendances->get();
        foreach ($attendances as $k => $v) {
            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }

            $v->department = $department;

            $created_at = is_null($v->created_at) ? '-' : $v->created_at;
            $updated_at = is_null($v->updated_at) ? '-' : $v->updated_at;
            $v->hari = Carbon::parse(explode(' ', $created_at)[0])->translatedFormat('l');
            $v->hari = Carbon::parse(explode(' ', $updated_at)[0])->translatedFormat('l');
        }

        return view('reports.absensi', compact('attendances'));
    }

    public function show_detail(Request $request)
    {
        $attendances = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select('attendances.user_fullname',
                'attendances.clock_in_time',
                'attendances.clock_in_img',
                'attendances.clock_in_loc',
                'attendances.created_at',
                'attendances.updated_at',
                'attendances.work_hour',
                'attendances.user_id',
                'users.nik',
                'users.department')
            ->where('attendances.id',$request->id)
            ->get();
        foreach ($attendances as $k => $v) {
            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }
            $v->department = $department;
            $late_limit = date_create(date('08:06:00'));
            $clock_in = date_create(date('H:i:s', strtotime($v->clock_in_time)));
            $difDate = date_diff($late_limit, $clock_in);
            $v->late = $difDate->h.':'.$difDate->i.':'.$difDate->s;
            $created_at = is_null($v->created_at) ? '-' : $v->created_at;
            $updated_at = is_null($v->updated_at) ? '-' : $v->updated_at;
            $v->hari = Carbon::parse(explode(' ', $created_at)[0])->translatedFormat('l');
            $v->hari = Carbon::parse(explode(' ', $updated_at)[0])->translatedFormat('l');
        }
        return view('reports.show_detail', compact('attendances'));
    }

    public function reportsTelat(Request $request)
    {
        if (Auth::User()->department == 1 || Auth::User()->department == 2 || Auth::User()->department == 3 || Auth::User()->department == 4 || Auth::User()->department == 5) {
            return redirect('/');
        }

        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::forget('first_date');
        Session::forget('end_date');
        $thn_awal = date('Y');
        $bln_awal = date('m');

        $thn_akhir = date('Y');
        $bln_akhir = date('m');

        $attendances = DB::SELECT("SELECT a.id
            , a.user_id
            , a.user_fullname
            , a.clock_in_time
            , a.clock_out_time
            , a.work_hour
            , a.created_at
            , u.nik
            , u.department
            FROM attendances a
            LEFT JOIN users u
                ON a.user_id = u.id
            WHERE 1=1
                AND a.created_at >= '$thn_awal-$bln_awal-01'
                AND a.created_at <= '$thn_akhir-$bln_akhir-31'"
        );

        // get duplicate value from attendances
        $duplicate_value = [];
        foreach ($attendances as $k => $v) {
            if (Auth::User()->department != 0) {
                if (Auth::User()->department != $v->department) {
                    // continue;
                }
            }

            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }

            $v->department = $department;

            $duplicate_value[$v->user_id] = $v;
        }

        // set custom value needed for attendances
        $custom_att = [];
        $no = 1;
        foreach ($duplicate_value as $k_dupplicate => $v_dupplicate) {
            $late = 0;
            $not_in_out = 0;
            $not_in = 0;
            $not_out = 0;

            foreach ($attendances as $k => $v) {
                $late_limit = date_create(date('08:06:00'));
                $clock_in = date_create(date('H:i:s', strtotime($v->clock_in_time)));
                $difDate = date_diff($late_limit, $clock_in);

                if ($k_dupplicate == $v->user_id) {
                    $tmp_late = ($difDate->h != 0 || $difDate->i != 0 | $difDate->s != 0) ? 1 : 0;
                    $late += $tmp_late;
                    $not_in_out += (empty($v->clock_in_time) || !isset($v->clock_in_time) && empty($v->clock_out_time) || !isset($v->clock_out_time)) ? 1 : 0;
                    $not_in += (empty($v->clock_in_time) || !isset($v->clock_in_time)) ? 1 : 0;
                    $not_out += (empty($v->clock_out_time) || !isset($v->clock_out_time)) ? 1 : 0;
                }
            }

            $jumlah = $late + $not_in_out + $not_in + $not_out;

            $denda = 10000;
            $custom_denda = number_format($denda, 0);

            $potongan = $jumlah * $denda;
            $custom_potongan = number_format($potongan, 0);

            $custom_att[] = [
                'no' => $no++,
                'nik' => $v_dupplicate->nik,
                'nama_karyawan' => $v_dupplicate->user_fullname,
                'departemen' => $v_dupplicate->department,
                'hari_kerja' => 21,
                'bulan' => date('F Y', strtotime(explode(' ', $v_dupplicate->created_at)[0])),
                'late' => $late,
                'not_in_out' => $not_in_out,
                'not_in' => $not_in,
                'not_out' => $not_out,
                'jumlah' => $jumlah,
                'denda' => $custom_denda,
                'potongan' => $custom_potongan,
            ];
        }

        return view('reports.telat', compact('custom_att'));
    }

    public function filter(Request $request)
    {
        $first_date = $request->first_date;
        $end_date = $request->end_date;
        Session::put('first_date', $request->first_date);
        Session::put('end_date', $request->end_date);

        $thn_awal = explode('-', $first_date)[0];
        $bln_awal = explode('-', $first_date)[1];

        $thn_akhir = explode('-', $end_date)[0];
        $bln_akhir = explode('-', $end_date)[1];

        $attendances = DB::SELECT("SELECT a.id
            , a.user_id
            , a.user_fullname
            , a.clock_in_time
            , a.clock_out_time
            , a.work_hour
            , a.created_at
            , u.nik
            , u.department
            FROM attendances a
            LEFT JOIN users u
                ON a.user_id = u.id
            WHERE 1=1
                AND a.created_at >= '$thn_awal-$bln_awal-01'
                AND a.created_at <= '$thn_akhir-$bln_akhir-31'"
        );

        // get duplicate value from attendances
        $duplicate_value = [];
        foreach ($attendances as $k => $v) {
            if (Auth::User()->department != 0) {
                if (Auth::User()->department != $v->department) {
                    // continue;
                }
            }

            $department = '';
            if ($v->department == 0) {
                $department = 'IT';
            } elseif ($v->department == 1) {
                $department = 'Marketing';
            } elseif ($v->department == 2) {
                $department = 'Kalibrasi';
            } elseif ($v->department == 3) {
                $department = 'IPM';
            } elseif ($v->department == 4) {
                $department = 'UK';
            } elseif ($v->department == 5) {
                $department = 'Servis';
            } elseif ($v->department == 6) {
                $department = 'HRD';
            }

            $v->department = $department;
            $duplicate_value[$v->user_id] = $v;
        }

        // set custom value needed for attendances
        $custom_att = [];
        $no = 1;
        foreach ($duplicate_value as $k_dupplicate => $v_dupplicate) {
            $late = 0;
            $not_in_out = 0;
            $not_in = 0;
            $not_out = 0;

            foreach ($attendances as $k => $v) {
                $late_limit = date_create(date('08:06:00'));
                $clock_in = date_create(date('H:i:s', strtotime($v->clock_in_time)));
                $difDate = date_diff($late_limit, $clock_in);

                if ($k_dupplicate == $v->user_id) {
                    $tmp_late = ($difDate->h != 0 || $difDate->i != 0 | $difDate->s != 0) ? 1 : 0;
                    $late += $tmp_late;
                    $not_in_out += (empty($v->clock_in_time) || !isset($v->clock_in_time) && empty($v->clock_out_time) || !isset($v->clock_out_time)) ? 1 : 0;
                    $not_in += (empty($v->clock_in_time) || !isset($v->clock_in_time)) ? 1 : 0;
                    $not_out += (empty($v->clock_out_time) || !isset($v->clock_out_time)) ? 1 : 0;
                }
            }

            $jumlah = $late + $not_in_out + $not_in + $not_out;

            $denda = 10000;
            $custom_denda = number_format($denda, 0);

            $potongan = $jumlah * $denda;
            $custom_potongan = number_format($potongan, 0);

            $custom_att[] = [
                'no' => $no++,
                'nik' => $v_dupplicate->nik,
                'nama_karyawan' => $v_dupplicate->user_fullname,
                'departemen' => $v_dupplicate->department,
                'hari_kerja' => 21,
                'bulan' => date('F Y', strtotime(explode(' ', $v_dupplicate->created_at)[0])),
                'late' => $late,
                'not_in_out' => $not_in_out,
                'not_in' => $not_in,
                'not_out' => $not_out,
                'jumlah' => $jumlah,
                'denda' => $custom_denda,
                'potongan' => $custom_potongan,
            ];
        }

        return view('reports.telat', compact('custom_att'));
    }

    public function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0) {
            return 0;
        }

        if (count($parts) == 1) {
            return $parts[0];
        }

        return floatval($parts[0]) / floatval($parts[1]);
    }

    /**
     * get_image_location
     * Returns an array of latitude and longitude from the Image file
     * @param $image file path
     * @return multitype:array|boolean
     */
    public function get_image_location($image = '')
    {
        $exif = exif_read_data($image, 0, true);

        if ($exif
            && isset($exif['GPS']['GPSLatitudeRef'])
            && isset($exif['GPS']['GPSLatitude'])
            && isset($exif['GPS']['GPSLongitudeRef'])
            && isset($exif['GPS']['GPSLongitude'])
        ) {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude = $exif['GPS']['GPSLongitude'];

            $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

            return array('latitude' => $latitude, 'longitude' => $longitude);
        } else {
            return false;
        }
    }
}
