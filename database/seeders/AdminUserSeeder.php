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
            'first_name' => 'Billy',
            'last_name' =>  'Rahmadi',
            'email' =>  'billy@globalpromedika.co.id',
            'password' =>   Hash::make('promedika'),
            'role'  =>  '0',
            'created_by' => '1',
            'updated_by' => '1',
            'start_date' => '2022-05-09',
            'end_date' => '3022-05-09',
        ]);
    }
}
