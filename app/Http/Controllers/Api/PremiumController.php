<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Premium;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\PremiumService;

class PremiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all premiums
        $premiums = Premium::all();
        return response()->json($premiums);
    }


    public function store(Request $request)
    {
      try{
          //start by verifying if premium for this product doesn't already exist
        if(count(Premium::where('product_code', '=', $request->product)
        ->where('time_length','=', $request->time_length."_".$request->time_unit)->get()) > 0){
            return response()->json([
                'status'=>'error',
                'message'=>'A premium for this product already exist!'
            ]);
        }
        $premium = new Premium();
        $premium->product_code = $request->product;
        $premium->time_length = $request->time_length."_".$request->time_unit;
        $premium->time_in_seconds = PremiumService::convertTimtToSeconds($request->time_length, $request->time_unit);
        $premium->amount = $request->amount;

        $premium->save();

        return response()->json([
            'status'=>'success',
            'message'=>'New premium created successfully!'
        ]);
      }catch(\Exception $err){
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage()
            ]);
      }


    }

}
