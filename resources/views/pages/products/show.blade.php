@extends('layouts/shared')

@section('contents')

<div class="row">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3"> <i class="sitemap icon"></i>Product Details</h4></div>
    <div class="col-6 my-3">
        <table class="table">
            <tbody>
                <tr>
                    <td>Product Code: </td>
                    <td>{{$product->product_code}}</td>
                </tr>
                <tr>
                    <td>Product Name: </td>
                    <td>{{$product->product_name}}</td>
                </tr>
                <tr>
                    <td>Brief Description: </td>
                    <td>{{$product->product_description}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-md btn-warning">Update Product Details</button>
        <button class="btn btn-md btn-danger">Delete Product</button>
        <button class="btn btn-md btn-primary">View Metrics</button>
    </div>
</div>

@endsection
