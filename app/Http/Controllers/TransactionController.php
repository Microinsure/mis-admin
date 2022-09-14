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
        if(Auth::check()){
            return view('pages.transactions.index')->with([
                'title'=>'Transactions',
                'subtitle'=>'Search'
            ]);
        }
        return redirect()->route('login')->withErrors([
            'access_denied' => 'Your session has expired. Please login to continue!'
        ]);
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

    public static function Transact($msisdn,$amount, $payment_channel, $account_number, $subscription){

        switch($payment_channel){
            case 'airtel-money':
                return PaymentProcessingService::RequestAirtelMoneyPayment($msisdn, $amount,$account_number, $subscription);
                break;
            case 'tnm-mpamba':

                break;
        };
    }


}
