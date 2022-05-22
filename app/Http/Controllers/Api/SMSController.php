<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SMSMessage;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Fetch all records from SMSMessage and filter with msisdn and date if available
        try{
            $sms = SMSMessage::query();
            if(request()->has('msisdn')){
                $sms->where('msisdn', request()->msisdn);
            }
            if(request()->has('date')){
                //Convert time to default laravel format
                $date = date('Y-m-d', strtotime(request()->date));
                $sms->where('date',$date);
            }
            $sms = $sms->get();

            return response()->json(['status' => 'success','message'=>count($sms).' Records found!', 'data' => $sms]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error','message'=>$e->getMessage()]);
        }
    }


    public static function store(Request $request){
        if($request->has('msisdn') && !empty($request->msisdn)){
            if($request->has('message') && !empty($request->message)){
                if(self::sendSMS($request->msisdn, $request->message)){
                    //Log SMS into Database
                        //Step 1: Split number string into array
                        $phoneNumbersArray = explode(',',$request->msisdn);
                        //Step 2: Loop through each number and log into database
                        foreach($phoneNumbersArray as $phoneNumber){
                            $smsMessage = new SMSMessage();
                            $smsMessage->msisdn = $phoneNumber;
                            $smsMessage->contents = $request->message;
                            $smsMessage->save();
                        }
                    return response()->json(['status' => 'success', 'message' => 'SMS sent successfully!']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'SMS not sent'], 500);
                }
            }else{
                return response()->json(['status'=>'error','message'=>'No message defined!'],406);
            }
        }else{
            return response()->json(['status'=>'error','message'=>'Please provide a valid phone number(s) !'],406);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendSMS($msisdn,$message){
        $username = 'MAZIKOFINTECHLTD'; // use 'sandbox' for development in the test environment
        $apiKey   = 'b7b32d1e3404e7d4e64f0a90ebb3d366eb8bfc033e75adc79e033cbc606da883'; // use your sandbox app API key for development in the test environment
        $senderId = 'MicroInsure';
        $AT       = new AfricasTalking($username, $apiKey);

        $sms      = $AT->sms();

        try{
            $result   = $sms->send([
                'to'      => $msisdn,
                'message' => $message,
                'from'    => $senderId
            ]);

            return true;
        }catch(\Exception $e){
            return false;
        }
    }


}
