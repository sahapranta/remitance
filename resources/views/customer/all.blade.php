@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._message')
            <div class="card">
                <div
                    class="card-header bg-success text-white d-flex justify-content-between"
                >
                    <h4>Welcome!</h4>
                    <a href="{{ route('home') }}" class="btn btn-dark">Home</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>All Customer</h4>
                            <a
                                href="{{ route('customer.create') }}"
                                class="btn btn-outline-dark shadow-sm"
                                >Create New Customer</a
                            >
                        </div>
                        <div class="card-body">
                            <div class="information">
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
                                                <td>
                                                    {{$customer->identification}}
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex justify-content-center"
                                                    >
                                                        <a
                                                            href="{{route('customer.show', $customer->id)}}"
                                                            class="btn btn-sm mr-1 btn-outline-dark"
                                                            >View</a
                                                        >
                                                        <a
                                                            href="{{route('remitance.create', ['customer'=>$customer->id])}}"
                                                            class="btn btn-sm mr-1 btn-outline-primary"
                                                            >Remitance</a
                                                        >
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
                            </div>
                            <div class="pagination justify-content-center">
                                {{$customers->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
