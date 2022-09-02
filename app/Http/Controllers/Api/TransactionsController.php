<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            //Grab customer_ref from the request
            $customer_ref = request()->customer_ref;
            //Validate if customer_ref exist
            if(!$customer_ref){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Customer ref is required'
                ],400);
            }
            //Get all transactions for the customer_ref
            $transactions = Transaction::where('txn_account_number',$customer_ref)->get();
            //Return the transactions
            return response()->json([
                'status'=>'success',
                'message'=>'Transactions retrieved successfully',
                'data'=>$transactions
            ],200);
        }catch(\Exception $err){
            return response()->json([
                'status'=>'error',
                'message'=>'An error occurred while retrieving transactions',
                'error'=>$err->getMessage()
            ],500);
        }
    }


    public function handleCallback(Request $request)
    {
        $service = request()->service;
        try{
            if($service == 'airtelmoney'){
                $handle = self::handleAirtelMoneyCallback($request);
                return ($handle == 'OK') ? response()->json(['message'=>'OK'],200) : response()->json(['message'=>$handle],500);
            }
        }catch(\Exception $err){

        }
    }

    private static function handleAirtelMoneyCallback($data){
        // TS = Transaction Success && TF = Transaction Failure
        try{
            $transaction = Transaction::where('txn_internal_reference', '=', $data->transaction->id)->first();
            $transaction->txn_external_reference = $data->transaction->airtel_money_id;
            $transaction->txn_status = ($data->transaction->status_code == 'TS') ? 'SUCCESS' : 'FAILED';
            $transaction->txn_message = $data->transaction->message;

            $transaction->save();

            if($data->transaction->status_code == 'TS'){
                $subscription = Subscription::where('subscription', '=', $transaction->subscription)->first();
                $subscription->payment_status = 'PAID';
                $subscription->validity = 'ACTIVE';

                $subscription->save();
            }

            return "OK";
        }catch(\Exception $err){
            return $err->getMessage();
        }
    }
}
