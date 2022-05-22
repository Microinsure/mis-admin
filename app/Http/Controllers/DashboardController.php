<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(Auth::check()){

        //Get all users
        $users = User::from('users AS u')->join('roles AS r', 'u.role','=','r.id')->get([
            'u.firstname','u.lastname','u.email','u.msisdn','u.email_verified_at','r.role_name AS role'
        ]);
        return view('pages.dashboard.index')->with([
            'title' => 'Dashboard',
            'subtitle' => 'Statictics',
            'users'=>$users
        ]);
       }else{
        return redirect()->route('login')->withErrors([
            'access_denied' => 'You need to login first!'
        ]);
       }
    }

}
