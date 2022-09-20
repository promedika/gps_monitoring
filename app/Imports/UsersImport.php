<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * 
    */
    public function model(array $row)
    {
        // dd($row);
        return new User([
            "first_name" => $row['first_name'],
            "last_name" => $row['last_name'],
            "email" => $row['email'],
            "password" => Hash::make($row['password']),
            "department" => $row['department'],
            "role"  =>  $row['role'],
            "start_date" => $row['start_date'],
            "end_date" => $row['end_date'],
            "created_by" => Auth::User()->id,
            "updated_by" =>Auth::User()->id,
            "status" => 'active'
        ]);
    }

    public Function HeadingRow(): int
    {
        return 19;
    }
    
}
