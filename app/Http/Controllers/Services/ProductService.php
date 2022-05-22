<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\InsuranceProduct;
use Illuminate\Http\Request;

class ProductService extends Controller
{

    public function createProduct($data)
    {
        //Validate Details
        if(self::validateProductDetaills($data)){
            $product = new InsuranceProduct();
            $product->product_name = $data->product_name;
            $product->product_description = $data->product_description;

            $product->save();

            return "OK";

        }else{
            return "Invalid Details";
        }
    }

    private static function validateProductDetaills($data)
    {
        if(isset($data->product_name) && !empty($data->product_name)
        && isset($data->product_description) && !empty($data->product_description)){
            return true;
        }

        return false;
    }
}
