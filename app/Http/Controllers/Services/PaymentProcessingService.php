<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class PaymentProcessingService extends Controller
{

    public static function RequestAirtelMoneyPayment($msisdn, $amount, $account_number, $subscription)
    {
        //Request Authorization Token

        $response = self::requestAirtelToken();
        if($response['status'] == 'success'){
            $token = $response['token'];
            //Then send a prompt to the customer
            $url = "https://openapiuat.airtel.africa/merchant/v1/payments/";
            $payload = [
                        "reference"=>'Microinsure',
                        "subscriber"=>[
                            'country'=>"MW",
                            'currency'=>'MWK',
                            'msisdn'=> 999959024//992560217//999959024//substr($msisdn, 3, (strlen($msisdn) - 1))
                        ],
                        'transaction'=>[
                            'amount'=>$amount,
                            'country'=>"MW",
                            "currency"=>"MWK",
                            "id"=>self::GetTransactionReference($account_number)
                        ]
                ];
            $response = Http::withToken($token)
            ->withHeaders(['X-Country'=>"MW",'X-Currency'=>"MWK"])
            ->acceptJson()->timeout(30)->post($url, $payload);

            $response = $response->json();
            if ($response['status']['code'] == '200') {
                $transaction = new Transaction();
                $transaction->txn_internal_reference = $response['data']['transaction']['id'];
                $transaction->txn_account_number = $account_number;
                $transaction->txn_amount = $amount;
                $transaction->txn_description = 'Payment of Insurance Premium';
                $transaction->subscription = $subscription;
                $transaction->txn_channel = 1;

                $transaction->save();
            }

            // return [
            //     'request'=>$payload,
            //     'response'=>$response
            // ];
            return $response;

        }else{
            return $response['message'];
        }

    }


    private static function requestAirtelToken(){
        $payload = [
            'client_id'=> env('AIRTEL_MONEY_API_KEY'),
            'client_secret' => env('AIRTEL_MONEY_API_SECRET'),
            'grant_type' => 'client_credentials'
        ];
        $url = "https://openapiuat.airtel.africa/auth/oauth2/token";

        try{
            $response = Http::acceptJson()->timeout(30)->post($url, $payload);
            $response = $response->json();
            if(array_key_exists('access_token', $response)){
                return array('status'=>'success', 'token'=>$response['access_token']);
            }else{
                return array('status'=>'error', 'message'=>$response['error_description']);
            }
        }catch(\Exception $err){
            return array('status'=>'error', 'message'=>$err->getMessage());
        }
    }

    private static function GetTransactionReference($account_number){
        //Generate proposed transaction id
        //1. Generate random 5 digit number
        $random_part = rand(10000, 99999);
        //2. Calculate number of transaction by user
        $number_txn_count = count(Transaction::where('txn_account_number', '=', $account_number)->get())+1;
        if($number_txn_count < 10){
            $number_txn_count .= '000';
        }
        if ($number_txn_count >= 10 && $number_txn_count < 100) {
            $number_txn_count .= '00';
        }
        if ($number_txn_count >= 100 && $number_txn_count < 1000) {
            $number_txn_count .= '0';
        }
        $_proposed_txn_id = "MIS".$random_part.$number_txn_count;

        //Now check if the generated id already exist in your database
        if(count(Transaction::where('txn_internal_reference', '=', $_proposed_txn_id)->get()) > 0){
            return self::GetTransactionReference($account_number);
        }
        return $_proposed_txn_id;
    }
}
