@extends('layouts.app') @section('css')
<style>
    .menu .card {
        background: linear-gradient(to right, #fbfff1, #fff7f7);
        transition: 0.2s ease-in;
    }
    .menu .card:hover {
        background: linear-gradient(to left, #f4fae3, #ffdddd);
        box-shadow: 5px 5px 10px -5px rgba(20, 20, 20, 0.7);
        border: 2px solid #b49f9f;
        cursor: pointer;
        transform: skewX(0.5deg);
    }
</style>
@endsection @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Welcome!</h4>
                </div>
                <div class="card-body text-center">
                    <div class="row menu">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('check') }}">
                                        <i
                                            class="fa fa-3x fa-search-plus mb-2 text-primary"
                                        ></i>
                                        <h5>
                                            Check Customer
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-user-plus mb-2 text-success"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.create') }}"
                                            >Create Customer</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-address-book mb-2"
                                        style="color:var(--indigo)"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}"
                                            >All Customers</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-cog mb-2 text-danger"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('settings') }}"
                                            >Settings</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-cog mb-2"
                                        style="color:var(--pink)"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}"
                                            >Settings</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-cog mb-2"
                                        style="color:var(--teal)"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}"
                                            >Settings</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-cog mb-2"
                                        style="color:var(--orange)"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}"
                                            >Settings</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i
                                        class="fa fa-3x fa-cog mb-2"
                                        style="color:var(--cyan)"
                                    ></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}"
                                            >Settings</a
                                        >
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4>
                        Notifications
                        <small class="badge badge-light">{{auth()->user()->notification_count}}</small>
                    </h4>
                </div>
                <div class="body">
                    <div class="list-group">
                        @forelse (auth()->user()->unreadNotifications as
                        $notification)
                        <a
                            href="{{$notification->data['link']}}"
                            class="list-group-item list-group-item-action"
                        >
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{$notification->data['data']}}
                                </h5>
                                <small
                                    >{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small
                                >
                            </div>
                            <small>Created by: {{$notification->data['user']}}</small>
                        </a>
                        @empty
                        <a class="list-group-item list-group-item-action" href="#"
                            >No New Notifications</a
                        >
                        @endforelse
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('markAsRead')}}" class="btn btn-sm btn-dark mr-2">
                        Mark as Read
                    </a>
                    <a href="{{route('notifications')}}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
