<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Services\ActivityLoggerService;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function logout()
    {

        $user_id = Auth::user()->id;
        $description = 'Logged out at '.date('Y-m-d H:i:s');
        ActivityLoggerService::LogUserAction($user_id, 'UPDATE', $description);

        Auth::logout();

        return Redirect::to('login');
    }

    public function authenticate(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:4' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')->withErrors($validator); // send back all errors to the login form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email'     => $request->email,
                'password'  => $request->password
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                $user_id = Auth::user()->id;
                $description = 'Logged in to account at '.date('Y-m-d H:i:s');
                ActivityLoggerService::LogUserAction($user_id, 'READ', $description);

                return redirect()->intended('dashboard')->withSuccess('Login was successfull!');
            } else {

                // validation not successful, send back to form
                return Redirect::to('login')->withErrors([
                    'access_denied' => 'Wrong username or password!'
                ]);
            }
        }
    }
}
