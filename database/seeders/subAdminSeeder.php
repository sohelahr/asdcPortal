<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class subAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'ASDC subAdmin',
            'email' => 'subadmin@asdc.com',
            'password' => Hash::make('123456789'),
            'user_type' => '2'
        ]);
    }
}
