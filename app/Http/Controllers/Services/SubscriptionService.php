<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Premium;
use App\Models\Transaction;
use App\Http\Controllers\TransactionController;

class SubscriptionService extends Controller
{
    public static function createSubscription($data){
       try{
            $subscription = new Subscription();

            $subscription->account_number = $data->customer_ref;
            $subscription->product_code = $data->policy;
            $subscription->subscription_type = $data->subscription;
            $subscription->amount = self::calculatePremium($data);
            $subscription->startdate =  date('Y-m-d H:i:s', strtotime($data->startdate));

            $subscription->save();

            $transaction = TransactionController::Transact($data->msisdn, $subscription->amount, $data->paymentChannel, $data->customer_ref, $subscription->id);


            return ['status'=>'OK', 'data'=>$transaction];
       }catch(\Exception $e){
           return ['status'=>'error', 'message'=> $e->getMessage()];
       }
    }


    private static function calculatePremium($data){
        $premium = Premium::findOrFail($data->premium);
        $defaultAmount = $premium->amount;
        //Some login to calculate the premium here

        return $defaultAmount;
    }
}
