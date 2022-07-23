<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\StaffActivityLogger;
use App\Models\CustomerActivityLogger;
use Illuminate\Http\Request;

class ActivityLoggerService extends Controller
{
  public static function LogUserAction($user_id, $action, $description){
        try{
            $activity = new StaffActivityLogger();

            $activity->user_id = $user_id;
            $activity->action = $action;
            $activity->description = $description;

            $activity->save();

            return true;
        }catch(\Exception $e){
            return false;
        }
  }

  public static function LogCustomerAction($customer_ref, $action, $description){
        try{
            $activity = new CustomerActivityLogger();

            $activity->customer_ref = $customer_ref;
            $activity->action = $action;
            $activity->description = $description;

            $activity->save();

            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}
