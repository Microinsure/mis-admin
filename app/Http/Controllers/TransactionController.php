<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionChannel;
use App\Http\Controllers\Services\PaymentProcessingSerice;
use App\Http\Controllers\Services\PaymentProcessingService;

class TransactionController extends Controller
{
    //
    public function index(Request $request){

    }

    public function create(){
        if(Auth::check()){
            $channels = TransactionChannel::all();
            return view('pages.transactions.create')->with([
                'title'=>'Transactions',
                'subtitle'=>"Initiate",
                'channels'=>$channels
            ]);
        }
        return redirect()->route('login')->withErrors([
            'access_denied' => 'You must be logged in to access this page!'
        ]);
    }

    private static function Transact($msisdn,$amount, $payment_channel){

        switch($payment_channel){
            case 'airtel-money':
                PaymentProcessingService::RequestAirtelMoneyPayment($msisdn, $amount);
                break;
            case 'tnm-mpamba':

                break;
        };
    }

}
