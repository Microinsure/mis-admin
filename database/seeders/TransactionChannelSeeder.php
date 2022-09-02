<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionChannel;

class TransactionChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $txn_channels = [
            'Airtel Money',
            'TNM Mpamba',
            'FDH Bank',
            'PayPal'
        ];

        foreach($txn_channels as $channel){
            TransactionChannel::create([
                'channel_name'=>$channel
            ]);
        }
    }
}
