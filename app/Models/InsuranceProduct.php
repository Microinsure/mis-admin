<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//Import Carbon
use Illuminate\Support\Carbon;

class InsuranceProduct extends Model
{
    use HasFactory;

    //Add fillable fields
    protected $fillable = [
        'product_name',
        'product_description',
        'product_created_at',
        'product_updated_at'
    ];

    protected $casts = ['created_at','updated_at'];

    //Format created_at and updated_at fields
    public $timestamps = true;


    //set product code in boot function
    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {
            $model->product_code = self::generateProductCode();
        });
    }

    //Generate 6 character unique alphanumeric product_code  and validate if it doesn't exist
    private static function generateProductCode()
    {
        $product_code = strtoupper("PR".rand(100,999));

        if(!self::where('product_code', $product_code)->exists()){
            return $product_code;
        }else{
            return self::generateProductCode();
        }
    }

    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date);//->format('Y-m-d');
    // }

    // public function getUpdatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date);//->format('Y-m-d');
    // }
}
