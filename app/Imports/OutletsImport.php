<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class OutletsImport implements ToModel, WithHeadingRow
{
    /**
    * 
    */
    public function model(array $row)
    {
        return new Outlet([
            "name" => $row['name'],
            "created_by" => Auth::User()->id,
            "updated_by" =>Auth::User()->id
        ]);
    }

    public Function HeadingRow(): int
    {
        return 14;
    }
    
}
