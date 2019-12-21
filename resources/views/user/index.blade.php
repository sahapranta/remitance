@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('layouts._message')
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h4>User Management</h4>
                    <a href="{{ route('home') }}" class="btn btn-light">Home</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                @foreach($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{route('user.edit', $user->id)}}">{{$user->id}} | {{$user->name}}</a>
                                    <form action="{{route('user.admin')}}" method="post">
                                        <input type="hidden" name="user" value="{{$user->id}}">
                                        @csrf
                                        @if($user->is_admin)
                                        <input type="hidden" name="role" value="user">
                                        <input type="submit" class="btn btn-danger btn-sm badge-pill" value="admin" />
                                        @else
                                        <input type="hidden" name="role" value="admin">
                                        <input type="submit" class="btn btn-secondary btn-sm badge-pill" value="user" />
                                    @endif
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection