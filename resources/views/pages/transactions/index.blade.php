@extends('layouts/shared')

@section('contents')

<div class="row">
        <div class="col-12 my-4"><h4 class="bg-secondary text-white p-3">
            <i class="search icon"></i> Transaction Lookup</h4>
            <hr>
        </div>
        <div class="col-12 text-right">
            <button class="btn btn-primary flat">Open Search Tray </button>
        </div>
        <div class="col-12">

            <table class="table table-sm table-striped table-bordered" id="transactionsTable">
                <thead>
                    <th>#</th>
                    <th>CustomerPhone</th>
                    <th>OrderNumber</th>
                    <th>TxnReference</th>
                    <th>Amount</th>
                    <th>PSPChannel</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>TxnDate</th>
                    <th></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

</div>
<script>
    let transactionTable
    $(()=>{
        transactionTable = $('#transactionsTable').DataTable({
            processing: true,
            serverSide: true,
            search:false,
            bFilter:false,
            searchable:false,
            ajax: {
                "url": "{{config('app.url')}}/api/v1/transactions/search",
                "type": "GET",
                "data": {
                    "token": ""
                }
            }

        });
    })
</script>

@endsection
