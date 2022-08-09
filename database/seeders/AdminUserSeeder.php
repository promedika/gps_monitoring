<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'password' =>   bcrypt('promedika'),
            'role'  =>  '0',
        ]);
    }
}
