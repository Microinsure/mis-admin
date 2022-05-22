@extends('layouts/shared')


@section('contents')

<div  class="main-container row pt-4 ">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3">
        <i class="icon user circle"></i> View Customer File (CF/{{$customer->customer_ref}}) |
        <span class="text-right float-right">[ Status: <span class="@if($customer->status == 'ACTIVE')
            text-success @else @if($customer->status == 'UNVERIFIED')
            text-warning @else text-danger @endif  @endif">{{$customer->status}} </span> ] </span></h4>
    </div>

    <div class="col-4">
        <fieldset class=" p-2">
            <legend class="p-2 bg-secondary text-center text-white">Customer Id Image</legend>
            <div id="imageCanvas">
                Click Here to upload Image
            </div>
        </fieldset>
    </div>
    <div class="col-6">
        <legend class="p-2 bg-secondary text-center text-white">Background Details</legend>

        {{-- Customer Profile Page --}}
        <table class="table table-sm table-bordered">
            <tbody>
                <tr>
                    <td>Customer Ref:</td>
                    <td>{{$customer->customer_ref}}</td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>{{$customer->firstname}} {{$customer->middlename}} {{$customer->lastname}}</td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>{{$customer->gender}}</td>
                </tr>
                <tr>
                    <td>Contact Phone:</td>
                    <td>{{$customer->msisdn}}</td>
                </tr>
                <tr>
                    <td>Email Address:</td>
                    <td>{{$customer->email}}</td>
                </tr>
                <tr>
                    <td>Physical Address:</td>
                    <td>{{$customer->address}}</td>
                </tr>
                <tr>
                    <td>Create At:</td>
                    <td>{{$customer->created_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-2">
        <legend class="p-2 bg-secondary text-center text-white">Action</legend>
        <hr>
        <button id="activateCustomerBtn" @if($customer->status == 'ACTIVE') disabled @endif class="ui icon button fluid  my-2 @if($customer->status != 'ACTIVE') positive @endif">Activate Account <i class="icon check circle"></i></button>
        <button class="ui icon button fluid  my-2 facebook">Reset PIN <i class="icon lock"></i></button>
        <hr>
        <button id="suspendCustomerBtn" @if($customer->status != 'ACTIVE') disabled @endif class="ui icon button fluid  my-2 @if($customer->status == 'ACTIVE') negative @endif">Suspend Account <i class="icon close"></i></button>
        <button class="ui icon button fluid  my-2 yellow">Update Details <i class="icon edit"></i></button>


    </div>
    <div class="col-12"><hr>
        <fieldset class="border border-secondary">
            <legend>Latest Transactions</legend>
            <table id="datatablesSimple" class="table table-sm table-bordered">
                <thead>
                    <th>#Txn_Ref</th>
                    <th>Txn_Amount</th>
                    <th>Txn_Description</th>
                    <th>Txn_Channel</th>
                    <th>Txn_Origin</th>
                    <th>#Txn_Date</th>
                    <th></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </fieldset>
    </div>
</div>


<style>
    #imageCanvas{
        width:100%;
        height:31vh;
        border:thin solid black;
        background-image: url('{{config('app.url')}}/nat-id-placeholder.png');
        background-repeat: no-repeat;
        background-size: cover;
        background-clip: contain;
        background-position: top center;
    }
</style>

<script>
    $(()=>{
        $("#activateCustomerBtn").click(async()=>{
            const PROMPT_MESSAGE = "That you woulf like to manually activate this customer's account?";
            const PROMPT = await ConfirmAction(PROMPT_MESSAGE)
            if(PROMPT){
                updateCustomerStatus('active')
            }
        })

        $("#suspendCustomerBtn").click(async()=>{
            const PROMPT_MESSAGE = "That you woulf like to manually activate this customer's account?";
            const PROMPT = await ConfirmAction(PROMPT_MESSAGE)
            if(PROMPT){
                updateCustomerStatus('suspended')
            }
        })
    })
    let updateCustomerStatus = async (status)=>{
        try{
            $(".main-container").addClass('ui segment loading').attr('disabled',true);
            const options = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    customer_ref: '{{$customer->customer_ref}}',
                    status:status.toUpperCase()
                })
            }
            let response  = await fetch(`${BASE_URL}/api/v1/customers/update-status`, options)
            response = await response.json()
            if(response.status == 'success'){
                swal('Complete!', response.message, 'success')
                setTimeout(()=>{location.reload()},2000)
            }else{
                swal('Process Failed!', response.message, 'error')
            }
        }catch(err){
            console.log(err)
            swal('Process Failed!', 'Might due to a crash or server error. Please try again later.', 'error')
        }finally{
            $(".main-container").removeClass('ui segment loading');
        }
    }
</script>
@endsection
