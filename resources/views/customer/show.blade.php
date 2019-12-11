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
                    <span class="text-muted">Created by: {{$customer->User->name}} | at: {{$customer->create_date}}</span>
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
                            <a href="{{ route('customer.edit', $customer->id)}}" class="btn btn-block btn-primary">Edit</a>
                            <button class="btn btn-block btn-info">Pay Incentive</button>
                            <a href="{{route('remitance.create', ['customer'=>$customer->id])}}" class="btn btn-block btn-secondary">Pay Remitance</a>
                            <button class="btn btn-block btn-dark">Generate Report</button>
                            <button class="btn btn-block btn-danger">Delete</button>
                        </div>
                    </div>
           
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>Sender</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Incentive</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($remitances as $remitance)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$remitance->sending_country}}</td>
                                    <td>{{$remitance->sender}}</td>
                                    <td>{{$remitance->payment_date}}</td>
                                    <td>{{$remitance->amount}}</td>
                                    <td>{{$remitance->incentive_amount}}</td>
                                    <td>
                                        @if($remitance->incentive_amount > 0)
                                            <button class="btn btn-sm btn-danger" disabled>Paid</button>
                                        @else
                                            <a href="{{route('remitance.edit', $remitance->id)}}" class="btn btn-sm btn-outline-danger">Pay</a>
                                        @endif
                                        <a href="{{route('remitance.show', $remitance->id)}}" class="btn btn-sm btn-outline-dark ml-1">view</a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end">
                            {{$remitances->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection