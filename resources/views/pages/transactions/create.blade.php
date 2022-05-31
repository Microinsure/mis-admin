
@extends('layouts/shared')

@section('contents')

<div class="row">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3">
        <i class="refresh icon"></i> Initiate Transaction</h4></div>
        <hr>
    <div class="col-8">
        <fieldset class="border border-secondary p-2">
            <legend>Transaction Details</legend>
            <form action="" class="ui form" id="transactionForm">
                <div class="form-row">
                    <div class="col-6 form-group">
                        <label for="">Select Customer :</label>
                        <input type="tel" value="+265" id="customer_phone"  name="customer_phone"  class="phone-field form-control" required>
                    </div>
                    <div class="col-2 form-group pt-2">
                        <br>
                        <button type="button" id="refresher" class="mt-2 ui mini button circular positive"> &nbsp;  <i class="icon refresh"></i></button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-3">
                        <label for="">Transaction Type :</label>
                        <select name="transaction_type" disabled style="padding-top:5px !important;padding-bottom:5px !important;"
                        id="transaction_type" class="form-control freezable frozen" required>
                            <option value="">Select</option>
                            <option value="refund">Refund</option>
                            <option value="compensation">Compensation</option>
                        </select>
                    </div>
                    <div class="col-6 form-group">
                        <label for="">Policy :</label>
                        <select name="policy" disabled id="policy" style="padding-top:5px !important;padding-bottom:5px !important;"
                        class="form-control freezable frozen" required>
                            <option value="">Select</option>

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="">Transaction Channel :</label>
                        <select name="transaction_channel" disabled style="padding-top:7px !important;padding-bottom:7px !important;"
                        id="transaction_channel" class="form-control freezable frozen" required>
                            <option value="">Select</option>
                            @foreach($channels AS $channel)
                                <option value="{{$channel->id}}">{{$channel->channel_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <label for="">Beneficiary Name(s) :</label>
                        <input type="tel" value="" placeholder="e.g John Banda, Ernest Banda e.t.c" name="beneficiaries" disabled class="form-control freezable frozen" required>
                        {{-- <div class="form-group pt-2 text-right">
                            <label class="mt-0 text-info"><i>Same Customer</i> </label>
                            <input type="checkbox" value="" disabled class="freezable frozen mt-1" id="same_as_customer_number">
                        </div> --}}
                    </div>
                    <div class="col-9">
                        <label for="">Comment / Description :</label>
                        <textarea name="description" disabled id="description" cols="30" rows="3" class="freezable frozen form-control" required></textarea>
                        <p class="text-danger"><b> <i>Max 255 Characters</i></b></p>
                    </div>
                    <div class="col-3">
                        {{-- <label class="text-white">_________</label> --}}
                        <br> <br>
                        <button type="submit" disabled class=" freezable frozen btn mt-4 btn-lg btn-block btn-success">Initiate <i class="icon check circle"></i></button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
    <div class="col-4">
        <fieldset class="border border-secondary p-2">
            <legend>Customer Preview</legend>

                <div id="imageCanvas">

                </div>
                <table class="table" id="customerDetailsTable">

                </table>
        </fieldset>
    </div>
</div>
<style>
    .frozen{
        background: rgb(192, 192, 192) !important;
    }

</style>
<style>
    #imageCanvas{
        width:100%;
        height:25vh;
        border:thin solid black;
        background-image: url('{{config('app.url')}}/nat-id-placeholder.png');
        background-repeat: no-repeat;
        background-size: cover;
        background-clip: contain;
        background-position: center center;
    }
</style>
<script>
    let customer_reference = null
    $(()=>{
        $("#same_as_customer_number").change(function(){
            console.log(this.value)
        })

        $("#refresher").click(function(){
            searchCustomer($("#customer_phone").val());
        })

        $("#transactionForm").submit(function(e){
            e.preventDefault();
            const data = getFormData('transactionForm')
            InitiateTransaction(data)
        })
    })
    function toggleSameAsCustomerNumber(){
        let value = $("#same_as_customer_number").attr('checked')
        alert(value)
    }

    async function searchCustomer(msisdn){
        try{
            $("#refresher").addClass('loading')
                console.log('Searching...')
                let response = await fetch(BASE_URL+"/api/v1/customers?msisdn="+msisdn)
                let data = await response.json()

                if(data.status == 'success'){
                    console.log(data)

                    if(data.data.length > 0){
                        //$("#imageCanvas").css("background-image", "url('"+data.image+"')");
                        $('.freezable').attr('disabled',false).removeClass('frozen');
                        RenderCustomerDetailsComponent(data.data[0])
                    }else{
                        customer_reference = null
                        Toast('System could not resolve phone to account!','error')
                    }
                }else{
                    customer_reference = null
                    $("#imageCanvas").css("background-image", "url('{{config('app.url')}}/nat-id-placeholder.png')");
                    $('.freezable').attr('disabled',true).addClass('frozen');
                    //Sweet alert
                    Toast('System could not resolve phone to account!','error')
                }
            }catch(err){
                customer_reference = null
                console.log(error)
                swal('Search Error!', "Something went wrong. Search could not be completed", 'error')
            }finally{
                $("#refresher").removeClass('loading')
            }
    }

    function RenderCustomerDetailsComponent(data){
        customer_reference = data.customer_ref
        console.log('Rendeing customer details...')
        let DOM = `<tr>
                        <th>Name :</th>
                        <th>${data.firstname} ${data.middlename != null ? data.middlename : ''} ${data.lastname}</th>
                    </tr>
                    <tr>
                        <th>Gender :</th>
                        <th>${data.gender}</th>
                    </tr>
                    <tr>
                        <th>Phone  :</th>
                        <th>${data.msisdn}</th>
                    </tr>
                    <tr>
                        <th>Email :</th>
                        <th>${data.email}</th>
                    </tr>
                    <tr>
                        <th>Address :</th>
                        <th>${data.address}</th>
                    </tr>`


        try{
            $("#customerDetailsTable").html(DOM)
            Toast("Customer account resolved from phone number!",'info')
        }catch(error){
            console.log(error)
            //swal('Error!', "Something went wrong. Customer details could not be resolved", 'error')
        }



    }
    async function InitiateTransaction(data){
        data.customer_ref = customer_reference
        data.user_id = '{{Auth::user()->id}}'
        console.log(data)
        try{
            if(Isset(data.customer_ref) && Isset(data.amount) &&
            Isset(data.transaction_type) && Isset(data.transaction_channel)
            && Isset(data.description) && Isset(data.policy)){
                $("#transactionForm").addClass('loading')
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                }
                let response = await fetch(`${BASE_URL}/api/v1/journalentries`, options)
                let data = await response.json()

                Toast(data.message,data.status)
                if(data.status == 'success'){
                    swal('Complete!',data.message,data.status)
                    $("#transactionForm").trigger('reset')
                    $("#imageCanvas").css("background-image", "url('{{config('app.url')}}/nat-id-placeholder.png')");
                    $('.freezable').attr('disabled',true).addClass('frozen');
                    location.href = "/transactions/unapproved"
                }else{
                    swal('Failed!',data.message,data.status)
                }
            }else{
                swal('Blocked!', "Some required fields are missing", 'error')
            }
        }catch(err){
            console.log(err)
            swal('Error!', "Something went wrong. Transaction could not be initiated", 'error')
        }finally{
            $("#transactionForm").removeClass('loading')
        }
    }

    function Insset(field){
        if(field && field != null && field != '' && field != typeof undefined){
            return true
        }
        return false
    }
</script>

@endsection
