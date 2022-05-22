@extends('layouts/shared')

@section('contents')

    <div class="row">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3"> <i class="icon plus circle"></i> Register New Customer</h4></div>
    <div class="col-7">
        <form class="ui form" action="#" id="newCustomerForm">
            <fieldset class="mt-2">
                <legend class="p-2 bg-secondary text-white">Customer Details</legend>
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="">FirstName :</label>
                        <input type="text" placeholder="(Required)" name="firstname" class="form-control" required>
                    </div>
                    <div class="col-4 form-group">
                        <label for="">MiddleName :</label>
                        <input type="text"  placeholder="(Optional)" name="middlename" class="form-control">
                    </div>
                    <div class="col-4 form-group">
                        <label for="">LastName :</label>
                        <input type="text"  placeholder="(Required)" name="lastname" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label for="">Gender :</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">Select</option>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label for="">Phone :</label>
                        <input type="text" name="msisdn" placeholder="(Required)" value="+265" class="form-control" required>
                    </div>
                    <div class="col-5 form-group">
                        <label for="">Email Address :</label>
                        <input type="email" name="email" placeholder="(Optional)" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 form-group">
                        <label for="">Home Address :</label>
                        <input type="text" name="address" placeholder="e.g Village, T/A, District" class="form-control" required>
                    </div>
                    <div class="col-4 form-group offset-8 p-4">
                        <button type="submit" class="ui button medium fluid positive icon">Submit Data <i class="icon check circle"></i></button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="col-4">
        <fieldset class=" p-2">
            <legend class="p-2 bg-secondary text-center text-white">Customer Id Image</legend>
            <div id="imageCanvas">
                Click Here to upload Image
            </div>
        </fieldset>
    </div>
    <div class="col-8 mx-auto p-2">
        <hr>
        <label for="" class="text-danger text-center">
            <string><span class="text-secondary">NOTE :</span> </string> Make sure you have provided only the correct user information.
            Once the record has been posted, you can no longer make changes to the Customer File!
        </label>
    </div>
</div>

<style>
    #imageCanvas{
        width:100%;
        height:35vh;
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
        $("#newCustomerForm").submit(async function(e){
            e.preventDefault();

            const data = {
                'firstname':$('input[name=firstname]').val(),
                'middlename':$('input[name=middlename]').val(),
                'lastname':$('input[name=lastname]').val(),
                'gender':$('#gender').val(),
                'email':$('input[name=email]').val(),
                'msisdn':$('input[name=msisdn]').val(),
                'address':$('input[name=address]').val()
            }
            const PROMPT_MESSSAGE = "You want to register this customer?";
            const prompt = await ConfirmAction(PROMPT_MESSSAGE)
            if(prompt){
                CreateUsers(data)
            }
        })
    })

    //Create user registration function

    let CreateUsers = async(data)=>{
        try{
            $('#newCustomerForm').addClass('loading')
            let response = await fetch(`${BASE_URL}/api/v1/customers`,{
                method:'POST',
                headers:{
                    'Accept':'application/json',
                    'Content-Type':'application/json'
                },
                body:JSON.stringify(data)
            })
            let responseData = await response.json();

            if(responseData.status == 'success'){
                swal('Complete!',responseData.message, 'success')
                location.href = `${BASE_URL}/customers/${responseData.data.user_id}`;
            }else{
                swal('Failed!',responseData.message, 'error')
            }
        }catch(err){
            console.log(err)
            swal('Connection Error!',"Make sure you are connected to a stable internet source!", 'error')
        }finally{
            $("#newCustomerForm").removeClass('loading');
        }
    }



</script>
@endsection
