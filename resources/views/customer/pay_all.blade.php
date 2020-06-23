@extends('layouts.app') @section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between">
                <h4>Pay Incentive</h4>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-dark mr-2">Back</a>
                    <a href="{{ route('home') }}" class="btn btn-light">Home</a>
                </div>
            </div>
            <div class="card-body">
            <multiple-incentive :remitances="{{$customer->unpaid_remitances}}" customer="{{$customer->id}}"></multiple-incentive>                              
            </div>
        </div>
    </div>
</div>
@endsection