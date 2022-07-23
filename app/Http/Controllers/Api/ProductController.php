<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InsuranceProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\ProductService;

class ProductController extends Controller
{



    public function index()
    {
        try{
            $products = InsuranceProduct::all();

            return response()->json([
                'status'=>'success',
                'data'=>$products
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        //Create product
        $productService = new ProductService();
        $createProductResponse = $productService->createProduct($request);

        if($createProductResponse == "OK"){
            return response()->json([
                'status'=>'success',
                'message'=>'Product created successfully!'
            ]);
        }else{
            return response()->json([
                'status'=>'error',
                'message'=>$createProductResponse
            ],400);
        }

    }

    public function getByCategory(){
        $category = request()->category;
        $products = InsuranceProduct::where('category',$category)->get();
        return response()->json([
            'status'=>'success',
            'message'=>'Products retrieved successfully!',
            'data'=>$products
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InsuranceProduct  $insuranceProduct
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceProduct $insuranceProduct)
    {
        return response()->json([
            'status'=>'success',
            'data'=>$insuranceProduct
        ]);
    }

}
