@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._message')
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h4>Welcome!</h4>
                    <a href="{{route('home')}}" class="btn btn-dark">Home</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Check Customer</h4>
                            <a href="{{route('customer.create')}}" class="btn btn-outline-dark shadow-sm">Create New Customer</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('check-customer')}}">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" placeholder="Identification Number" class="form-control @error('identification') is-invalid @enderror"
                                            name="identification" value="{{ old('identification') }}" required
                                            autocomplete="identification" autofocus>
                                        <div class="input-group-append">
                                            <input class="btn btn-outline-danger" type="submit" value="Check" />
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            <div class="information">
                                @if($customers)
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($customers as $customer)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$customer->name}}</td>
                                                <td>{{$customer->identification}}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{route('customer.show', $customer->id)}}" class="btn btn-sm mr-1 btn-outline-dark">View</a>
                                                        <a href="{{route('remitance.create', ['customer'=>$customer->id])}}" class="btn btn-sm mr-1 btn-outline-primary">Remitance</a>
                                                        @if(count($customer->unpaid_remitances))
                                                        <a
                                                            href="{{ route('remitance.all', $customer->id)}}"
                                                            class="btn btn-sm btn-outline-danger"
                                                        >
                                                            Incentive
                                                        </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <h5>Not Found...</h5>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection