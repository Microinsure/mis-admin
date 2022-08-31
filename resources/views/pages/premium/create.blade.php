@extends('layouts/shared')

@section('contents')

<div class="row">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3">
        <i class="icon money"></i> Create Premiums</h4></div>

    <div class="col-8">
        <fieldset class="">
            <form action="#" id="newPremiumForm" >
                <div class="form-row">
                        <div class="form-group col-3">
                            <label for="">Category :</label>
                            <select name="category" id="categroy" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories AS $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Policy/Product :</label>
                            <select name="product" id="product" disabled class="form-control" required>
                                <option value="">Select Policy</option>

                            </select>
                        </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="">Time Length :</label>
                        <input type="number" name="time_length" id="time_length" placeholder="(Required)" min="0" class="form-control" required/>
                    </div>
                    <div class="col-2 form-group">
                        <label for="">Time Unit</label>
                        <select name="time_unit" id="time_unit" class="form-control" required>
                            <option value="">Select</option>
                            <option value="days">Days</option>
                            <option value="weeks">Weeks</option>
                            <option value="months">Months</option>
                            <option value="years">Years</option>
                        </select>
                    </div>
                    <div class="col-3 form-group">
                        <label for="">Amount (MK)</label>
                        <input type="number" name="amount" id="amount" min="0" placeholder="(Required)" class="form-control" required/>
                    </div>
                    <div class="col-3 form-group pt-4">

                        <button type="submit" class="ui mt-2 button icon positive fluid tiny">Submit <i class="icon check circle"></i></button>
                    </div>
                </div>
                <div class="form-row">

                </div>
            </form>
        </fieldset>

    </div>
    <div class="col-12"><hr></div>
    <div class="col-12">
        <table id="premiumsTable" class="table table-sm table-hover table-striped">
            <thead>
                <th>#</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Time Length</th>
                <th>Amount</th>
                <th></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    $(()=>{
        console.log("Everything loaded!")
        $("#premiumsTable").DataTable({
            pageLength:8
        })

        $("#newPremiumForm").submit(function(e){
            e.preventDefault()
            const data = getFormData('newPremiumForm')
            console.log(data)

            createNewPremium(data)
        })

        $("#categroy").change(()=>{
            console.log('Something changed!')
            let category = $("#categroy").val()
            if(category != ''){
                getProductsBycategory(category)
            }
        })
    })

    async function getProductsBycategory(category){
        try{
            let response = await fetch(`${BASE_URL}/api/v1/products/category/${category}`)
            response = await response.json()

            if(response.status == 'success'){
                $("#product").html('')
                let DOM = response.data.map(product=>{
                    return `<option value="${product.product_code}">${product.product_name}</option>`;
                }).join()
                DOM += "<option selected value=''>Select</option>"
                $("#product").html(DOM)
                response.data.length > 0 ? $('#product').attr('disabled', false) : $('#product').attr('disabled', true)
            }else{
                alert('Failed to fetch Insurance Products!');
            }
        }catch(err){
            console.log(err)
            alert(err.message)
        }
    }

    let createNewPremium = async (data)=>{
        try{git 
            const options = {
                method:"POST",
                headers:{
                    'Contemt-Type':'application/json'
                },
                body:JSON.stringify(data)
            }
            let response = await fetch(BASE_URL+"/api/v1/premiums", options)
            response = await response.json()

            if(response.status == 'success'){
                setTimeout(() => {
                    location.reload()
                }, 2000);
            }else{
                swal('Error!', response.message, response.status)
            }
        }catch(err){
            swal('Connection Error!', err.message,'error')
        }
    }
</script>
@endsection
