<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{

        public function handle($request, Closure $next)
        {
            return $next($request)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods','GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, Authorization');
        }
    // public function handle(Request $request, Closure $next)
    // {
    //     header('Access-Control-Allow-Origin', '*');
    //     $headers = [
    //         //Methods: POST, GET, PUT, OPTIONS, DELETE
    //         'Access-Control-Allow-Methods'=>'*',
    //         //Headers: Origin, Content-Type, Authorization, X-Auth-Token
    //         'Access-Control-Allow-Headers'=>'*'
    //     ];
    //     if($request->getMethod() == 'OPTIONS'){
    //         return response('OK')->withHeaders($headers);
    //     }
    //     $response = $next($request);
    //     foreach($headers as $key => $value){
    //         $response->header($key, $value);
    //     }
    //     return $response;
    // }
}
