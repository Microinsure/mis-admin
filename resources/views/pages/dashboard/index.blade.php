@extends('layouts/shared')

@section('contents')

<div class="row">
    <div class="col-12">
        <h1 class="mt-4">{{$title}}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">{{$subtitle}}</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">{{$stats['customers']}}</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Total Customers</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">{{$stats['transactions']}}</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Transactions</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">MK{{$stats['total_deposits']}}</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">Total Deposits</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">MK1,240,000</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">In Compensations</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Internal Team
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th></th>
                                    </thead>

                                    <tbody>
                                        @foreach($users AS $user)
                                            <tr>
                                                <th>{{$user->firstname}} {{$user->lastname}}</th>
                                                <th>{{$user->role}}</th>
                                                <th>{{$user->msisdn}}</th>
                                                <th>{{$user->email}}</th>
                                                <th>@if($user->email_verified_at == NULL)Unverified @else Verified @endif</th>
                                                <th>
                                                    <a href="{{config('app.url')}}/customers/{{$user->id}}" class="btn btn-md btn-primary">View User</a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
    </div>
</div>
@endsection
