<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\CustomerService;
use App\Http\Controllers\Services\ActivityLoggerService;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Search customers by firstname, lastname, gender , phone or email if available
        try{
            $customer = Customer::where('customer_ref','!=',null);

            if($request->has('firstname') && !empty($request->firstname)){
                $customer->where('firstname','like','%'.$request->firstname.'%');
            }
            if($request->has('lastname') && !empty($request->lastname)){
                $customer->where('lastname','like','%'.$request->lastname.'%');
            }
            if($request->has('gender') && !empty($request->gender)){
                $customer->where('gender','=',$request->gender);
            }
            if($request->has('msisdn') && !empty($request->msisdn)){
                $customer->where('msisdn','like','%'.$request->msisdn.'%');
            }
            if($request->has('email') && !empty($request->email)){
                $customer->where('email','like','%'.$request->email.'%');
            }

            if($request->has('start') && !empty($request->start)){
                $customer = $customer->skip($request->start);
            }
            if($request->has('limit') && !empty($request->limit)){
                $customer = $customer->take($request->limit);
            }

            $customer = $customer->get();
            foreach($customer AS $customerObject){
                $customerObject->gender = ucwords($customerObject->gender);
                $customerObject->status = ucwords($customerObject->status);
            }

            try{
                $user_id = Auth::user()->id;
                $description = "View customers list!";
                ActivityLoggerService::LogUserAction($user_id, 'READ', $description);
            }catch(\Exception $err){
                
            }

            return response()->json([
                'status' => 'success',
                'message'=>count($customer)." results found!",
                'data' => $customer
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message'=>$e->getMessage()
            ]);
        }


    }

    public function store(Request $request)
    {
        //Receive request object and pass to Customer Service Class
        $validateCustomerResponse = CustomerService::validateCustomerDetails($request);
        if($validateCustomerResponse == 'OK'){
            $createCustomerResponse = CustomerService::createCustomer($request);
            if($createCustomerResponse['status'] == 'OK'){
                return response()->json([
                    'status' => 'success',
                    'message'=>'Customer created successfully!',
                    'data'=>[
                        'user_id'=>$createCustomerResponse['last_insert_id']
                    ]
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message'=>$createCustomerResponse
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message'=>$validateCustomerResponse
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */

     //Create update customer status function
    public function updateStatus(Request $request){
        //Update customer with $request->customer_ref with $request->status if not already set
        try{
            $customer = Customer::where('customer_ref','=',$request->customer_ref)->first();
            if($customer->status != strtoupper($request->status)){
                $customer->status = strtoupper($request->status);
                $customer->save();

                // Log user activity
                $user_id = Auth::user()->id;
                $description = 'Update Customer Status for '.$customer->customer_ref." to ".$customer->status;
                ActivityLoggerService::LogUserAction($user_id, 'UPDATE', $description);

                return response()->json([
                    'status' => 'success',
                    'message'=>'Customer status updated successfully!',
                    'data'=>[
                        'user_id'=>$customer->customer_ref
                    ]
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message'=>'Customer status already set to '.$request->status
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message'=>$e->getMessage()
            ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
