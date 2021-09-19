<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ASDC student',
            'email' => 'student@asdc.com',
            'password' => Hash::make('123456789'),
            'user_type' => '3'
        ]);
    }
}
