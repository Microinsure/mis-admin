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
        <button id="resetPinBtn" class="ui icon button fluid  my-2 facebook">Reset PIN <i class="icon lock"></i></button>
        <hr>
        <button id="suspendCustomerBtn" @if($customer->status != 'ACTIVE') disabled @endif class="ui icon button fluid  my-2 @if($customer->status == 'ACTIVE') negative @endif">Suspend Account <i class="icon close"></i></button>
        <button data-toggle="modal" data-target="#updateCustomerDetailsModal" data-backdrop="static" class="ui icon button fluid  my-2 yellow">Update Details <i class="icon edit"></i></button>


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


<!-- Update Customer Details Modal Start -->
<div class="modal fade" id="updateCustomerDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <form id="updateCustomerDetailsForm" class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title text-white" id="exampleModalLongTitle">Update Details</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-4 form-group">
                    <label for="">FirstName :</label>
                    <input type="text" placeholder="(Required)" value="{{$customer->firstname}}" name="firstname" class="form-control" required>
                </div>
                <div class="col-4 form-group">
                    <label for="">MiddleName :</label>
                    <input type="text"  placeholder="(Optional)" value="{{$customer->middlename}}" name="middlename" class="form-control">
                </div>
                <div class="col-4 form-group">
                    <label for="">LastName :</label>
                    <input type="text"  placeholder="(Required)" value="{{$customer->lastname}}" name="lastname" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-3 form-group">
                    <label for="">Gender :</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Select</option>
                        <option @if($customer->gender == 'MALE') selected @endif value="MALE">Male</option>
                        <option @if($customer->gender == 'FEMALE') selected @endif value="FEMALE">Female</option>
                    </select>
                </div>
                <div class="col-4 form-group">
                    <label for="">Phone :</label>
                    <input type="text" name="msisdn" placeholder="(Required)" value="{{$customer->msisdn}}" value="+265" class="form-control" required>
                </div>
                <div class="col-5 form-group">
                    <label for="">Email Address :</label>
                    <input type="email" name="email" value="{{$customer->email}}" placeholder="(Optional)" class="form-control">
                </div>
                <div class="col-12 form-group">
                    <label for="">Home Address :</label>
                    <input type="text" name="address" value="{{$customer->address}}" placeholder="e.g Village, T/A, District" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
          <button type="submit" class="btn btn-success">Submit Changes <i class="icon check circle"></i></button>
        </div>
    </form>
    </div>
  </div>
    <!-- Update Customer Details Modal End -->
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

        $("#resetPinBtn").click(async ()=>{
            const PROMPT_MESSAGE = "Are you sure you would like to reset this customers' PIN Code?";
            const PROMPT = await ConfirmAction(PROMPT_MESSAGE)
            if(PROMPT){
                resetCustomerPin()
            }
        })

        $("#updateCustomerDetailsForm").submit(async function(e){
            e.preventDefault();
            const PROMPT_MESSAGE = "Are you sure you would like to update customer file details?";
            const PROMPT = await ConfirmAction(PROMPT_MESSAGE)
            if(PROMPT){
                updateCustomerDetails()
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
            swal('Process Failed!', 'Might be due to application crash or server error. Please try again later.', 'error')
        }finally{
            $(".main-container").removeClass('ui segment loading');
        }
    }

    let updateCustomerDetails = async (data)=>{
        data.customer_ref = '{{$customer->customer_ref}}'
        data.user_id = '{{Auth::user()->id}}'
        try{
            $(".main-container").addClass('ui segment loading').attr('disabled',true);
            const options = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify(data)
            }
            let response  = await fetch(`${BASE_URL}/api/v1/customers/${'{{$customer->id}}'}`, options)
            response = await response.json()
            if(response.status == 'success'){
                swal('Complete!', response.message, 'success')
                setTimeout(()=>{location.reload()},2000)
            }else{
                swal('Process Failed!', response.message, 'error')
            }
        }catch(err){
            console.log(err)
            swal('Process Failed!', 'Might be due to application crash or server error. Please try again later.', 'error')
        }finally{
            $(".main-container").removeClass('ui segment loading');
        }
    }

    let resetCustomerPin = async ()=>{
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
                    user_id: '{{Auth()->user()->id}}'
                })
            }
            let response  = await fetch(`${BASE_URL}/api/v1/customers/reset-pin`, options)
            response = await response.json()
            if(response.status == 'success'){
                swal('Complete!', response.message, 'success')
            }else{
                swal('Process Failed!', response.message, 'error')
            }
        }catch(err){
            console.log(err)
            swal('Process Failed!', 'Might be due to application crash or server error. Please try again later.', 'error')
        }finally{
            $(".main-container").removeClass('ui segment loading');
        }
    }
</script>
@endsection
