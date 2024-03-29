<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Controllers\Api\SMSController;
use App\Models\Subscription;
use App\Models\InsuranceProduct;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function advancedSearch(Request $request){

        try{
            //DB::enableQueryLog();
            $transactions = Transaction::from('transactions AS t')
            ->join('transaction_channels AS tc', 'tc.id', '=', 't.txn_channel')
            ->join('subscriptions AS s', 's.id', '=', 't.subscription')
            ->join('customers AS c', 'c.customer_ref', '=', 't.txn_account_number')
            ->join('accounts AS acc', 'acc.account_number', '=', 'c.customer_ref');


            if ($request->has('customer_name')) {
                $transactions->where('c.firstname', '=', "%" . $request->customer_name . "%")
                ->where('c.lastname', '=', "%" . $request->customer_name . "%");
            }
            if ($request->has('msisdn')) {
                $transactions->where('c.msisdn', '=', $request->msisdn);
            }
            if ($request->has('order_number')) {
                $transactions->where('t.txn_internal_reference', '=', $request->order_number);
            }
            if ($request->has('txn_reference')) {
                $transactions->where('t.txn_external_reference', '=', $request->txn_reference);
            }
            if ($request->has('txn_status')) {
                $transactions->where('t.status', '=', $request->status);
            }
            if ($request->has('txn_channel')) {
                $transactions->where('t.txn_cnannel', '=', $request->txn_channel);
            }

            $transactions->get([
                'acc.account_name',
                'acc.account_number',
                'c.msisdn',
                't.txn_internal_reference AS order_number',
                't.txn_external_reference AS txn_reference',
                't.txn_amount AS amount',
                'tc.channel_name AS psp_name',
                't.status', 't.txn_description AS description',
                't.txn_message AS narration',
                't.created_at AS txn_date'
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>"Query completed successfully!",//dd(DB::getQueryLog())
                'data'=>$transactions
            ]);
        }catch(\Exception $err){
            return response()->json([
                'status'=>'error',
                'message'=>$err->getMessage()
            ]);
        }

    }


    public function handleCallback(Request $request)
    {
        $service = request()->service;

        try{
            self::storeCallbackToFile($request);
            if($service == 'airtelmoney'){
                $handle = self::handleAirtelMoneyCallback($request->all());
                return ($handle == 'OK') ? response()->json(['message'=>'OK'],200) : response()->json(['message'=>$handle],500);
            }
        }catch(\Exception $err){
            return response()->json(['message'=>$err->getMessage()],500);
        }
    }

    private static function handleAirtelMoneyCallback($data){
        // TS = Transaction Success && TF = Transaction Failure
        try{
            $transaction = Transaction::where('txn_internal_reference', '=', $data['transaction']['id'])->first();

            if($transaction == null){
                SMSController::sendSMS('+265994791131', json_encode($data));
                return;
            }
            $transaction->txn_external_reference = $data['transaction']['airtel_money_id'];
            $transaction->status = ($data['transaction']['status_code'] == 'TS') ? 'SUCCESS' : 'FAILED';
            $transaction->txn_message = $data['transaction']['message'];

            $transaction->save();

            $subscription = Subscription::where('id', '=', $transaction->subscription)->first();

            if($data['transaction']['status_code'] == 'TS'){
                $subscription->payment_status = 'PAID';
                $subscription->validity = 'ACTIVE';

                $subscription->save();
            }

            self::NotifyCustomer($data['transaction']['status_code'], $subscription,$transaction->txn_amount, $transaction);

            return "OK";
        }catch(\Exception $err){
            return $err->getMessage();
        }
    }

    private static function NotifyCustomer($status, $subscription, $amount, $transaction){

        $message = "";
        $details = InsuranceProduct::join('categories', 'categories.id', '=','insurance_products.category')
        ->join('premia', 'premia.product_code', '=', 'insurance_products.product_code')
        ->where('insurance_products.product_code', '=',$subscription->product_code)->get(
            [
                'insurance_products.product_name',
                'categories.category_name',
                'premia.time_length'
        ]);
        $details = $details[0];
        if($status == 'TS'){
            //Split time_length
            $time = explode('_', $details->time_length);
            $message = "Dear customer, you have paid a premium of MK" . number_format($amount, 2);
            $message .= " towards " . $details->product_name . " " . $details->category_name . " Product ";
            $message .= "valid for ".$time[0]." ".ucfirst($time[1]);
        }else{
            $message = "Failed premium payment for order ".$transaction->txn_internal_reference;
            $message .= " - ". $details->product_name . " " . $details->category_name . " Cover. ";
            $message .= "Make sure you enter the correct wallet Pin and you have sufficient balance";
        }
        $msisdn = Customer::where('customer_ref', '=', $transaction->txn_account_number)->first()->msisdn;
        SMSController::sendSMS($msisdn, $message);
    }

    public function checkTxnStatus(){
        $internal_reference = request()->internal_reference;
        return response()->json([
            'status'=>Transaction::where('txn_internal_reference', '=', $internal_reference)->first()->status
        ]);
    }

    private static function storeCallbackToFile($request){
        try{
            Storage::disk('public')->put('callbacks/order-' . $request['transaction']['id'] . '.json', json_encode($request->all()));
        }catch(\Exception $err){
            SMSController::sendSMS('+265994791131', json_encode($request));
        }
    }
}
