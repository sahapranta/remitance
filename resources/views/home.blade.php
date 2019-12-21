@extends('layouts.app') @section('css')
<style>
    .menu .card {
        background: linear-gradient(to right, #fbfff1, #fff7f7);
        transition: 0.2s ease-in;
    }

    .menu .card:hover {
        background: linear-gradient(to left, #f4fae3, #f8eaea);
        box-shadow: 5px 5px 10px -5px rgba(94, 94, 94, 0.5);
        cursor: pointer;
    }
</style>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js" integrity="sha256-ME1oxb2vK5SiiMtx+4oULIxCn2t84vyIKg3bp8Sw2gI=" crossorigin="anonymous"></script> -->
@endsection @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Welcome!</h4>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('check-customer') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" placeholder="Quick find Customer" class="form-control @error('identification') is-invalid @enderror" name="identification" value="{{ old('identification') }}" autofocus />
                                        <div class="input-group-append">
                                            <input class="btn btn-outline-danger" type="submit" value="Check" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-md-4">
                            <check-record token="{{ csrf_token() }}"></check-record>
                        </div> -->
                    </div>

                    <div class="row menu">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('check') }}">
                                        <i class="fa fa-3x fa-search-plus mb-2 text-primary"></i>
                                        <h5>
                                            Check
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('customer.create') }}"><i class="fa fa-3x fa-user-plus mb-2 text-success"></i>
                                        <h5>
                                            Customer
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('customer.index') }}">
                                        <i class="fa fa-3x fa-address-book mb-2" style="color:var(--indigo)"></i>
                                        <h5>
                                            Customers
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('settings') }}">
                                        <i class="fa fa-3x fa-cog mb-2 text-danger"></i>
                                        <h5>
                                            Settings
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('report.index') }}">
                                        <i class="fa fa-3x fa-file mb-2" style="color:var(--pink)"></i>
                                        <h5>
                                            Report
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->is_admin)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('user.index') }}">
                                        <i class="fa fa-3x fa fa-user-circle mb-2" style="color:var(--teal)"></i>
                                        <h5>
                                            User
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-cog mb-2" style="color:var(--orange)"></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}">Settings</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa fa-3x fa-cog mb-2" style="color:var(--cyan)"></i>
                                    <h5>
                                        <a href="{{ route('customer.index') }}">Settings</a>
                                    </h5>
                                </div>
                            </div>
                        </div> -->
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
                        <a href="{{$notification->data['link']}}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-truncate">
                                    {{$notification->data['data']}}
                                </h5>
                                <small>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </div>
                            <small>Created by:
                                {{$notification->data['user']}}</small>
                        </a>
                        @empty
                        <a class="list-group-item list-group-item-action" href="#">No New Notifications</a>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('markAsRead') }}" class="btn btn-sm btn-dark mr-2">
                        Mark as Read
                    </a>
                    <a href="{{ route('notifications') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection