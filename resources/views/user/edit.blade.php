@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white"><h4>Edit User Details</h4></div>
                <div class="card-body">
                    <div class="col-md-4">
                        <form action="{{route('user.update', $user->id)}}" method="post">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{old('name', $user->name)}}" name="name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" value="{{old('email', $user->email)}}" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" value="" name="password" placeholder="Set New Password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button class="btn btn-outline-dark btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection