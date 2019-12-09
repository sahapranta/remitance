@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between">
                <h4>Create New Customer</h4>
                <a href="{{route('customer.index')}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">
                <form action="{{route('customer.store')}}" method="POST" class="p-3">
                    @csrf
                    <div class="form-group">
                        <input type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Address" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{{ old('address') }}" required autocomplete="address">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" placeholder="Mobile No." class="form-control @error('mobile') is-invalid @enderror"
                                    name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                                    value="{{ old('birthdate') }}" required autocomplete="birthdate">
                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" placeholder="National ID." class="form-control @error('nid') is-invalid @enderror"
                                    name="nid" value="{{ old('nid') }}">
                                @error('nid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" placeholder="Passport ID." class="form-control @error('passport_id') is-invalid @enderror"
                                    name="passport_id" value="{{ old('passport_id') }}">
                                @error('passport_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" placeholder="Bank Account ID." class="form-control @error('account_id') is-invalid @enderror"
                                    name="account_id" value="{{ old('account_id') }}">
                                @error('account_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <input type="reset" value="Reset" class="btn btn-block btn-dark">
                        </div>
                        <div class="col-md-5 col-6">
                            <input type="submit" value="Submit" class="btn btn-block btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection