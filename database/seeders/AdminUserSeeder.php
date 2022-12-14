<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Super',
            'last_name' =>  'User',
            'nik' =>  '123456',
            'phone' =>  '021123456789',
            'password' =>   Hash::make('promedika'),
            'email' => 'super.user@gmail.com',
            'role'  =>  '0',
            'created_by' => '1',
            'updated_by' => '1',
            'start_date' => '2022-05-09',
            'end_date' => '3022-05-09',
            'status' => 'active'
        ]);
    }
}
