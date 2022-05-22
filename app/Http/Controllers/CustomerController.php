<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{

    public function index()
    {
        //Render customers page
       if(Auth::check()){
            return view('pages.customers.index')->with([
                'title'=>'Customers',
                'subtitle'=>'List'
            ]);
       }else{
            return redirect()->route('login')->withErrors([
                'access_denied' => 'You must be logged in to access this page!'
            ]);
       }
    }


    public function create()
    {
         //Render create customers page
       if(Auth::check()){
            return view('pages.customers.create')->with([
                'title'=>'Customers',
                'subtitle'=>'Create'
            ]);
        }else{
            return redirect()->route('login')->withErrors([
                'access_denied' => 'You must be logged in to access this page!'
            ]);
        }
    }

    public function show(Customer $customer)
    {
        //View customer details
        if(Auth::check()){
            return view('pages.customers.show')->with([
                'title'=>'Customers',
                'subtitle'=>'View',
                'customer'=>$customer
            ]);
        }else{
            return redirect()->route('login')->withErrors([
                'access_denied' => 'You must be logged in to access this page!'
            ]);
        }
    }

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
