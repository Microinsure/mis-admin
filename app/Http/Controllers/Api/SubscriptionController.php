<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\SubscriptionService;
class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fetchUserSubscriptions(Request $request)
    {
        try{
            $customer_ref = request()->customer_ref;

            $subscriptions = Subscription::from('subscriptions AS s')
            ->join('premia AS p', 'p.product_code','=', 's.product_code')
            ->join('insurance_products AS ip', 'ip.product_code', '=', 'p.product_code')
            ->where('account_number', '=', $customer_ref)
            ->get([
                'ip.product_code', 'ip.product_name','s.amount',
                'p.time_length','s.subscription_type', 's.payment_status',
                's.created_at', 's.startdate', 's.claim_status', 's.disbursement_status'
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>count($subscriptions)." records found!",
                'data'=>$subscriptions
            ]);
        }catch(\Exception $err){
            return response()->json([
                'status'=>'success',
                'message'=>$err->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {

        try{

            $subscriptionResponse = SubscriptionService::createSubscription($request);
           if($subscriptionResponse['status'] == 'OK'){
                return response()->json([
                    'status'=>'success',
                    'message'=>'Subscription placed successfully!',
                    'data'=>$subscriptionResponse['data']
                ]);
           }
           return response()->json([
                'status'=>'error',
                'message'=>$subscriptionResponse
            ]);
        }catch(\Exception $err){
            return response()->json([
                'status'=>'error',
                'message'=>$err->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
