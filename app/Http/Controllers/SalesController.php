<?php

namespace App\Http\Controllers;

use App\Models\Mkt_sale;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{   
    
    public function index()
    {
        
        if(Auth::User()->role != 1){
            $users = User::all();
            $targets = DB::select("
            SELECT s.first_name, s.last_name, m.sales_target, m.sales_start, m.sales_end, m.status, m.pencapaian
            FROM mkt_sales m
            LEFT JOIN users s ON m.user_id = s.id
            ");

        return view('sales.index', compact('targets','users'));
        }else{
        return redirect('error.404');
        }
    }
 
    public function create()
    {
        $users = User::get(["id","first_name"." "."last_name"]);
        return view('sales.create','users');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id'=>'required',
            'sales_target'=>'required',
            'sales_start'=>'required',
            'sales_end'=>'required',
        ]);

        $target_id = Auth::User()->id.'_'.time();

        $sales_target = (int) trim(str_replace(".", "", $request->sales_target));

        DB::table('mkt_sales')->insert([
            'id' => $target_id,
            'user_id' => $request->user_id,
            'sales_target' => $sales_target,
            'sales_start' => $request->sales_start,
            'sales_end' => $request->sales_end,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 'Belum Memenuhi',
        ]);
        return redirect(route('sales.index'))->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function input()
    {
        $users = User::get(["id","first_name","last_name"]);
        $outlets = Outlet::get(["id","name"]);
        $inputs = DB::select("
        SELECT u.first_name, u.last_name, o.name, h.sales_date, h.sales_value, h.jml_alat, h.jns_kerja, h.keterangan, h.status
        FROM sales_histories h
        LEFT JOIN users u ON h.user_id = u.id
        LEFT JOIN outlets o ON h.tenant_id = o.id
        ");
        return view('sales.input',compact('users','outlets','inputs'));
    }

    public function sales(Request $request)
    {
        $this->validate($request,[
            'user_id',
            'sales_date',
            'tenant_id',
            'sales_value',
            'mkt_sales_id',
            'jml_alat',
            'jns_kerja',
            'status',
        ]);

        $target = DB::table('mkt_sales')
        ->where('user_id', $request->user_id)
        ->get();
        
        // $sales_date = $request->sales_date;
        $sales_date = strtotime($request->sales_date);
        
        $mkt_id = '';
        foreach ($target as $key => $value) {
            if ($sales_date >= strtotime($value->sales_start) 
                && $sales_date <= strtotime($value->sales_end)) {
                    $sales_value = (int) trim(str_replace(".", "", $request->sales_value));
                    $mkt_id = $value->id;
                    $pencapaian = $value->pencapaian+$sales_value;
                    $sales_target = $value->sales_target;
                    $status = $pencapaian >= $sales_target ? 'Memenuhi Target' : 'Belum Memenuhi'; 
            }
        }

        DB::table('sales_histories')->insert([
            'sales_date' => $request->sales_date,
            'user_id' => $request->user_id,
            'tenant_id' => $request->tenant_id,
            'jns_kerja' => $request->jns_kerja,
            'jml_alat' => $request->jml_alat,
            'mkt_sales_id' => $mkt_id,
            'sales_value' => $sales_value,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('mkt_sales')
        ->where('id', $mkt_id)
        ->update([
            'pencapaian' => $pencapaian,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
