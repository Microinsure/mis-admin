<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;


class PremiumService extends Controller
{
  public static function convertTimtToSeconds($value, $unit){
    switch($unit){
        case 'days':
            return $value * 24 * 60 * 60;
        break;
        case 'weeks':
            return $value * 7 * 24 * 60 * 60;
        break;
        case 'months':
            return $value * 30 * 7 * 24 * 60 * 60;
        break;
        case 'years':
                return $value * 52.1429 * 30 * 7 * 24 * 60 * 60;
        break;
        default:
            return 0;
    }
  }
}
