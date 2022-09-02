<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Transaction;



class DashboardController extends Controller
{

    public function index()
    {
       if(Auth::check()){
        $total_deposits = Transaction::where('txn_amount', '>', 0)->where('status', '=', 'SUCCESS')->sum('txn_amount');
        $stats = [
            'customers'=>Customer::count(),
            'transactions'=>Transaction::count(),
            'total_deposits'=>number_format($total_deposits, 2)
        ];
        //Get all users
        $users = User::from('users AS u')->join('roles AS r', 'u.role','=','r.id')->get([
            'u.firstname','u.lastname','u.email','u.msisdn','u.email_verified_at','r.role_name AS role'
        ]);
        return view('pages.dashboard.index')->with([
            'title' => 'Dashboard',
            'subtitle' => 'Statictics',
            'users'=>$users,
            'stats'=>$stats
        ]);
       }else{
        return redirect()->route('login')->withErrors([
            'access_denied' => 'You need to login first!'
        ]);
       }
    }

}
