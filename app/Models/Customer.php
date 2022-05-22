<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status','firstname','lastname','middlename','gender','email','msisdn','address'
    ];

    //Generate 10 characher customer_ref and check if already exist
    public static function generateCustomerRef(){
        $customer_ref = substr(str_shuffle(str_repeat("0123456789", 10)), 0, 10);
        $customer = Customer::where('customer_ref',$customer_ref)->first();
        if($customer){
            return self::generateCustomerRef();
        }else{
            return $customer_ref;
        }
    }

    //Boot function to generate customer_ref
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->customer_ref = self::generateCustomerRef();
        });
    }
}
