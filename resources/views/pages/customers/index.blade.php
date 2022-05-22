@extends('layouts/shared')

@section('contents')

<div class="row pt-4">
    <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3"> <i class="icon users circle"></i> Customer Records</h4></div>
    <div class="col-9 ">
        <div class="text-right my-3">
            <a href="{{config('app.url')}}/customers/create" class="btn btn-md btn-success">Create Customer <i class="icon plus circle"></i></a>
        </div>
       <div class="card mb-4">

            <div class="card-header pb-0">
              <h6>Customers table</h6>
            </div>
            <div class="card-body  pt-2 pb-2">
                <table class="table table-bordered table-sm table-striped table-hover" id="customersTable">
                    <thead>
                        <th>CustomerId#</th>
                        <th>CustomerName</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Status</th>
                        <th></th>
                    </thead>

                </table>
            </div>
        </div>

    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <h6>Search Filter</h6>
            </div>
            <div class="card-body">
                <form action="#" class="text-start">
                    <div class="form-row">
                       <div class="form-group col-12">
                           <label for="">Customer Ref :</label>
                           <input type="text" class="form-control" name="customer_ref" placeholder="Optional">
                       </div>
                       <div class="col-12 form-group">
                           <label for="">Customer Name :</label>
                           <input type="text" name="customer_name" placeholder="Start typing..." class="form-control">
                       </div>
                       <div class="col-12 form-group">
                           <label for="">Gender :</label>
                           <select name="gender" id="" class="form-control">
                               <option value="">Select</option>
                               <option value="MALE">Male</option>
                               <option value="FEMALE">Female</option>
                           </select>
                       </div>
                       <div class="col-12 mt-2 form-group">
                            <button class="ui my-2 button icon fluid tiny positive">
                                Search Now <i class="icon search"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(()=>{

        //Implement Ajax DataTable
        $('#customersTable').DataTable({
            processing: true,
            serverSide: true,
            search:false,
            searchable:false,
            ajax: {
                "url": "{{config('app.url')}}/api/v1/customers",
                "type": "GET",
                "data": {
                    "token": ""
                }
            },
            columns: [
                {data: 'customer_ref', name: 'customer_ref'},
                {data: function(data, type, dataToSet) {
                    return data.firstname + " " + data.lastname;
                }, name: 'customer_name'},
                {data: 'gender',name:'gender'},
                {data: 'msisdn',name:'phone'},
                {data: 'address',name:'address'},
                {data: 'status',name:'status'},
                {data: 'id', render:function(data, type, row, meta ){
                    return `<a href="${BASE_URL}/customers/${data}" class="btn btn-sm btn-primary">View</a>`;
                }}
            ],
        });
    })
</script>

@endsection
