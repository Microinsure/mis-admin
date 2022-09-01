<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentProcessingService extends Controller
{

    public function RequestAirtelMoneyPayment($msisdn, $amount)
    {
        //Request Authorization Token
        $response = self::requestAirtelToken();
        if($response['status'] == 'success'){
            $token = $response['token'];
            //Then send a prompt to the customer
            $url = "https://openapiuat.airtel.africa/merchant/v1/payments/";
            $payload = [
                        "referencce"=>'Microinsure',
                        "subscriber"=>[
                            'country'=>"MW",
                            'currency'=>'MWK',
                            'msisdn'=>substr($msisdn, 3, (strlen($msisdn) - 1))
                        ],
                        'transaction'=>[
                            'amount'=>$amount,
                            'country'=>"MW",
                            "currency"=>"MWK",
                            "id"=>self::GetTransactionReference()
                        ]
                ];
            $response = Http::withToken($token)
            ->withHeaders(['X-Country'=>"MW",'X-Currency'=>"MWK"])
            ->acceptJson()->timeout(30)->post($url, $payload);

            $response = $response->json();
            if($response->status->code == '200'){

            }else{
                
            }
        }else{
            return $response['message'];
        }

    }


    private function requestAirtelToken(){
        $payload = [
            'client_id'=> env('AIRTEL_MONEY_API_KEY'),
            'client_secret' => env('AIRTEL_MONEY_API_SECRET'),
            'grant_type' => 'client_credentials'
        ];
        $url = "https://openapiuat.airtel.africa/auth/oauth2/token";

        try{
            $response = Http::acceptJson()->timeout(30)->post($url, $payload);
            $response = $response->json();
            if(array_key_exists('token', $response)){
                return array('status'=>'success', 'token'=>$response->token);
            }else{
                return array('status'=>'error', 'message'=>$response->error_description);
            }
        }catch(\Exception $err){
            return array('status'=>'error', 'message'=>$err->getMessage());
        }
    }

    private function GetTransactionReference(){

    }
}
