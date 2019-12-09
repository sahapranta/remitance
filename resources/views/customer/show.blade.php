@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._message')
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h4>Welcome!</h4>
                    <a href="{{route('customer.index')}}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4><b>Name: </b> {{$customer->name}}</h4>
                            <h4><b>Address: </b> {{$customer->address}}</h4>
                            <h4><b>Mobile: </b> {{$customer->mobile}}</h4>
                            <h4><b>Date of Birth: </b> {{$customer->birthdate}}</h4>
                            <h4><b>National ID: </b> {{$customer->nid}}</h4>
                            <h4><b>Account ID: </b> {{$customer->account_id}}</h4>
                            <h4><b>Passport ID: </b> {{$customer->passport_id}}</h4>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-block btn-primary">Edit</button>
                            <button class="btn btn-block btn-info">Pay Incentive</button>
                            <button class="btn btn-block btn-secondary">Pay Remitance</button>
                            <button class="btn btn-block btn-dark">Generate Report</button>
                            <button class="btn btn-block btn-primary">View History</button>
                        </div>
                    </div>
                    <hr>
                    <span>Created by: {{$customer->User->name}} | at: {{$customer->create_date}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection