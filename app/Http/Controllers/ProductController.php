<?php

namespace App\Http\Controllers;

use App\Models\InsuranceProduct;
use App\Models\Premium;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{


    public function index()
    {
        if(Auth::check()){
            $products = InsuranceProduct::all();
            $categories = Category::all();
            return view('pages.products.index')->with([
                'title'=>"Insurance Products",
                'subtitle'=>'List',
                'products'=>$products,
                'productCategories'=>$categories
            ]);
        }
        return redirect()->route('login')->withErrors([
            'access_denied' => 'You must be logged in to access this page!'
        ]);
    }

    public function show(InsuranceProduct $insuranceProduct)
    {
        $premuimDetails = Premium::where('product_code','=',$insuranceProduct->product_code)->get();
        //Display Product Information
        return view('pages.products.show')->with([
            'title'=>'Insurance Product',
            'subtitle'=>'Details',
            'product'=>$insuranceProduct,
            'premium'=>$premuimDetails
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InsuranceProduct  $insuranceProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(InsuranceProduct $insuranceProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InsuranceProduct  $insuranceProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceProduct $insuranceProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InsuranceProduct  $insuranceProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceProduct $insuranceProduct)
    {
        //
    }
}
