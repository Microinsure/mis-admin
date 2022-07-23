<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\SMSController;



class CustomerService extends Controller
{

    public static function createCustomer($data)
    {
        try{
            $customer = new Customer();

            $customer->firstname = $data->firstname;
            $customer->lastname = $data->lastname;
            $customer->middlename = $data->middlename;
            $customer->gender = $data->gender;
            $customer->msisdn = $data->msisdn;
            $customer->email = $data->email;
            $customer->address = $data->address;

            //Tracks whether the customer specified a PIN or if a default PIN was generated
            $isDefaultPin = false;

            //Create default customer PIN if not specified
            if(!$data->has('pin') || empty($data->pin)){
                $data->pin = self::generateDefaultPinNumber();
                $isDefaultPin = true;
            }
            $customer->pin = Hash::make($data->pin);
            $customer->save();
            self::NotifyUserOfSuccessfulRegistration($data,$isDefaultPin);

            return [
                'status'=>'OK',
                'message'=>'Account created successfully!',
                'last_insert_id'=>$customer->id
            ];
    }catch(\Exception $e){
        return [
            'status'=>'error',
            'error'=>$e->getMessage()
        ];
    }
}


public static function validateCustomerDetails($data){
    //Check if firstname, lastname, gender, msisdn exist
    if(self::isValid($data->firstname) && self::isValid($data->lastname) && self::isValid($data->gender)
    && self::isValid($data->msisdn)){
        //Check if phone number or email already exists
        if(Customer::where('msisdn','=',$data->msisdn)->exists()){
            return "An account with that phone number already exists";
        }
        if(!empty($data->email) && isset($data->email) && Customer::where('email','=',$data->email)->exists()){
            return "An account with that email already exists";
        }
        return 'OK';
    }else{
        return 'One or more required fields are missing!';
    }
}

    private static function isValid($field){
        if(isset($field) && !empty($field)){
            return true;
        }
        return false;
    }

    private static function generateDefaultPinNumber(){
        //Generate random 4 digit number and return it
        return (string) rand(1000,9999);
    }

    private static function NotifyUserOfSuccessfulRegistration($data,$defaulPinCreated){
        //Compose message and send to user
        if($defaulPinCreated){
            $message = "Congratulations $data->firstname!, You have successfully registered with us. Your default PIN is $data->pin. Please use this PIN to login to your account.\n\nThank you!";
        }else{
            $message = "Congratulations $data->firstname, You have successfully registered with us. Please use your PIN to login to your account.\n\nThank you!";
        }
        return SMSController::sendSMS($data->msisdn, $message);
    }
}
