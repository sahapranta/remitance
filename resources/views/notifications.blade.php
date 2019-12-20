@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('layouts._message')
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between">
                    <h4>
                        Notifications
                        <small class="badge badge-light">{{auth()->user()->notifications->count()}}</small>
                    </h4>
                    <a href="{{route('home')}}" class="btn btn-outline-light">Home</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse (auth()->user()->notifications as
                        $notification)
                        <a href="{{$notification->data['link']}}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
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
                    <a href="{{ route('markAsRead') }}" class="btn btn-outline-dark mr-2">
                        Mark All As Read
                    </a>
                    <form action="{{ route('notifications') }}" method="post">
                        @method('DELETE') @csrf
                        <input type="submit" value="Delete Old Notifications" class="btn btn-dark mr-2" onclick="event.preventDefault(); mconfirm('Are you Sure?', function(){event.target.form.submit();})" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection