<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionChannel;
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
}
