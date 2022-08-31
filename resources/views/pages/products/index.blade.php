@extends('layouts/shared')

@section('contents')

    <div class="row">
        <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3"> <i class="product hunt icon"></i> Insurance Products</h4></div>

        <div class="col-7">
            <table class="table table-striped table-bordered table-hover" id="productsTable">
                <thead>
                    <th>Ref Code</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


        <div class="col-5">
            <div class="card">
                <div class="card-header p-0">
                    <h4 class="bg-secondary text-white p-3"> <i class="plus circle icon"></i> Add New Product</h4>
                </div>
                <div class="card-body">
                    <form class="" id="addProductForm">

                        <div class="form-group mt-4">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="product_name" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required s>
                                <option value="">Select</option>
                                @foreach($productCategories as $productCategory)
                                    <option value="{{ $productCategory->id }}">{{ $productCategory->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="productDescription">Product Description</label>
                            <textarea class="form-control" id="productDescription" name="product_description" placeholder="Product Description" required></textarea>
                        </div>

                        <div class="form-group text-right my-3">
                            <button type="submit" class="ui right-floated float-right button positive circular medium">Add Product   <i class="icon check circle"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>

        $(()=>{
            $("#addProductForm").form({
                fields: {
                    product_name: {
                        identifier: 'product_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please enter product name'
                            }
                        ]
                    },
                    product_description: {
                        identifier: 'product_description',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please enter product description'
                            }
                        ]
                    }
                }
            });

            $("#addProductForm").submit(function(e){
                e.preventDefault();
                const data = {
                    product_name: $("#productName").val(),
                    product_description: $("#productDescription").val(),
                    category:$("#category").val()
                }
                createProduct(data);
            })
        })
        //Implement Ajax DataTable
        $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            search:false,
            searchable:false,
            ajax: {
                "url": "{{config('app.url')}}/api/v1/products",
                "type": "GET",
                "data": {
                    "token": ""
                }
            },
            columns: [
                {data: 'product_code', name: 'product_code'},
                {data: 'product_name',name:'product_name'},
                {data: 'product_description',name:'product_description'},
                {data: 'status',name:'status'},
                {data: 'created_at',name:'created_at'},
                {data: 'id', render:function(data, type, row, meta ){
                    return `<a href="${BASE_URL}/products/${data}" class="btn btn-sm text-white btn-primary">Details</a>`;
                }}
            ],
        });

        const createProduct = async (data)=>{
            try{
                //Freeze form and load
                $('#addProductForm').addClass('ui form loading');
                const options = {
                    'method':"POST",
                    'headers':{
                        'Content-Type':'application/json'
                    },
                    'body':JSON.stringify(data)
                }
                let response = await fetch(`${BASE_URL}/api/v1/products`,options);
                let result = await response.json();
                if(result.status == 'success'){
                    swal('Complete!',result.message, result.status)
                    $('#addProductForm').trigger('reset');
                    $('#productsTable').DataTable().ajax.reload();
                }else{
                    swal('Process Failed!',result.message, result.status)
                }
            }catch(err){
                swal('Connection Erro!','Make sure you have a stable internet connection!','error')
            }finally{
                $('#addProductForm').removeClass('ui form loading');
            }
        }
    </script>

@endsection
