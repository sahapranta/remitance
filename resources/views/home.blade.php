@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Welcome!</h4>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="card shadow-sm border border-dark">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-search-plus mb-2 text-primary"></i>
                                    <h4><a href="{{route('customer.index')}}">Check Customer</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="card shadow-sm border border-dark">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-user-plus mb-2 text-dark"></i>
                                    <h4><a href="{{route('customer.create')}}">Create Customer</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="card shadow-sm border border-dark">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-address-book mb-2 text-success"></i>
                                    <h4><a href="{{route('customer.index')}}">All Customers</a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="card shadow-sm border border-dark">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-cog mb-2 text-danger"></i>
                                    <h4><a href="{{route('customer.index')}}">Settings</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection