<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class OutletsImport implements ToModel, WithHeadingRow
{
    /**
    * 
    */
    public function model(array $row)
    {
        DB::table('outlets')->insert([
            "name" => $row['name'],
            "created_by" => Auth::User()->id,
            "updated_by" =>Auth::User()->id,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }

    public Function HeadingRow(): int
    {
        return 14;
    }
    
}
