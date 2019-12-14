@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div
                class="card-header bg-success d-flex justify-content-between"
            >
                <h4>Settings</h4>
                <div class="">
                    <a
                        href="{{url()->previous()}}"
                        class="btn btn-outline-light mr-2"
                        >Back</a
                    >
                    <a
                        href="{{ route('home') }}"
                        class="btn btn-dark"
                        >Home</a
                    >
                </div>
                <div class="card-body">
                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection