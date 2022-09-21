<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * 
    */
    public function model(array $row)
    {
        return new User([
            "first_name" => $row['first_name'],
            "last_name" => isset($row['last_name']) ? $row['last_name'] : ' ',
            "email" => $row['email'],
            "password" => Hash::make($row['password']),
            "department" => $row['department'],
            "role"  =>  $row['role'],
            "start_date" => date('Y-m-d', strtotime($row['start_date'])),
            "end_date" => date('Y-m-d', strtotime($row['end_date'])),
            "created_by" => Auth::User()->id,
            "updated_by" =>Auth::User()->id,
            "status" => 'active'
        ]);
    }

    public Function HeadingRow(): int
    {
        return 19;
    }

    public function rules(): array
    {
        return [
            '*.email' => 'unique:users|email'
        ];
    }
    
}
