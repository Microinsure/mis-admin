<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create default roles
        DB::table('roles')->insert(
            [
                'role_name'=>'System Administrator',
                'role_description'=>'This user is responsible for day-to-day system support and overall resolving of issues.'
            ],
            [
                'role_name'=>'Chief Executive Officer',
                'role_description'=>'This user has the highest operational role in the organization and is responsible for the overall management of the organization.'
            ],
            [
                'role_name'=>'Chief Operating Officer',
                'role_description'=>'This user is responsible for the day-to-day management of the organization.'
            ],
            [
                'role_name'=>'Accountant',
                'role_description'=>'This user is responsible for initiating, reading and recording all financial transactions in the system.'
            ]

        );
    }
}
