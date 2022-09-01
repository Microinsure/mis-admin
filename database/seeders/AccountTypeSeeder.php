<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountType;


class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = [
            'Individual', 'Group', 'Cash', 'Suspense'
        ];

        foreach($accountTypes AS $accountType){
            AccountType::create([
                'name'=>$accountType
            ]);
        }
    }
}
