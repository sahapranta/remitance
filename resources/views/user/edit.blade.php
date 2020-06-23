@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h4>Edit User Details</h4>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                        <a href="{{ route('home') }}" class="btn btn-light ml-2">Home</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="{{route('user.update', $user->id)}}" method="post">
                                @method('put') @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{old('name', $user->name)}}" name="name" />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" value="{{old('email', $user->email)}}" name="email" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="" name="password" placeholder="Set New Password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button class="btn btn-outline-dark btn-block">
                                    Submit
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{route('user.destroy', $user->id)}}" method="post">
                                @csrf @method('DELETE')
                                <div class="form-group">
                                    <input type="submit" value="DELETE" class="btn btn-danger btn-block" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection