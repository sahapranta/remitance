@extends('layouts.app') 
@section('css')
<style>
    .scroller {
        height: 200px;
        overflow-y: scroll;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="justify-content-center">
        @include('layouts._message')
        <div class="card">
            <div
                class="card-header bg-dark text-white d-flex justify-content-between"
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
                        class="btn btn-primary"
                        >Home</a
                    >
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <div class="accordion" id="accordionSetting">
                            <div class="card">
                                <div class="card-header" id="heading1">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapse1"
                                            aria-expanded="true"
                                            aria-controls="collapse1"
                                        >
                                            <b>Add New Settings</b>
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapse1"
                                    class="collapse show"
                                    aria-labelledby="heading1"
                                    data-parent="#accordionSetting"
                                >
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <form
                                                action="{{
                                                    route('settings.store')
                                                }}"
                                                method="post"
                                            >
                                                @csrf
                                                <div
                                                    class="form-group ml-2 mr-2"
                                                >
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            value="{{
                                                                old('name')
                                                            }}"
                                                            placeholder="Settings Name"
                                                        />
                                                        <input
                                                            type="text"
                                                            name="data[0]"
                                                            class="form-control"
                                                            value="{{
                                                                old('data[0]')
                                                            }}"
                                                            placeholder="Settings Value"
                                                        />
                                                        <input
                                                            value="Save"
                                                            type="submit"
                                                            class="btn btn-success"
                                                        />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @forelse($settings as $setting)
                            <div class="card">
                                <div
                                    class="card-header"
                                    id="heading-{{$loop->index + 1}}"
                                >
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link text-uppercase"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapse-{{$loop->index + 1}}"
                                            aria-controls="collapse-{{$loop->index + 1}}"
                                        >
                                            <b>{{$setting->name}}: </b>
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapse-{{$loop->index + 1}}"
                                    class="collapse"
                                    aria-labelledby="heading-{{$loop->index + 1}}"
                                    data-parent="#accordionSetting"
                                >
                                    <div class="card-body">
                                        <div class="ml-2 mr-2">
                                            <form
                                                action="{{ route('settings.update', $setting->id) }}"
                                                method="post"
                                            >
                                                @csrf @method('PUT')
                                                @if($setting->more_than_one)
                                                <input
                                                    type="text"
                                                    class="form-control mb-1"
                                                    name="data[{{count($setting->data)}}]"
                                                    placeholder="Add New value"
                                                />
                                                @endif
                                                <div class="@if($setting->more_than_one) scroller @endif row justify-content-center">                                                    
                                                    @forelse($setting->data as
                                                    $data)
                                                    <div class="@if($setting->more_than_one) col-md-4 col-6 @endif">
                                                        <div
                                                            class="input-group"
                                                        >
                                                            <input
                                                                type="text"
                                                                class="form-control mb-1"
                                                                name="data[{{$loop->index}}]"
                                                                value="{{
                                                                    $data
                                                                }}"
                                                            />
                                                            @if(1>=count($setting->data))
                                                            <input
                                                                type="submit"
                                                                value="Save"
                                                                class="btn btn-success float-right mb-1"
                                                            />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <p class="text-danger">
                                                        NO
                                                    </p>
                                                    @endforelse                                               
                                                </div>
                                                @if($setting->more_than_one)                                                    
                                                <input
                                                    type="submit"
                                                    value="Save"
                                                    class="btn btn-success btn-block mt-2"
                                                />
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            @empty @endforelse
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
