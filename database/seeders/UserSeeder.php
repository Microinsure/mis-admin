<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create default admin user
        DB::table('users')->insert([
            'firstname' => "Clifford",
            'middlename' => "Pemphero",
            'lastname' => "Mwale",
            'email' => 'cliffmwale97@gmail.com',
            'msisdn'=>'265994791131',
            'role'=>1,
            'password' => Hash::make('password'),
        ]);
    }
}
