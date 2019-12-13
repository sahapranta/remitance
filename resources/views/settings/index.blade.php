@extends('layouts.app') @section('content')
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
                        class="btn btn-outline-primary"
                        >Home</a
                    >
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
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
                                                <div class="row justify-content-center">
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
                                                    @if($setting->more_than_one)
                                                    <input
                                                        type="submit"
                                                        value="Save"
                                                        class="btn btn-success btn-block"
                                                    />
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            @empty @endforelse
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapseOne"
                                            aria-expanded="true"
                                            aria-controls="collapseOne"
                                        >
                                            COC LIst
                                        </button>
                                    </h2>
                                </div>

                                <div
                                    id="collapseOne"
                                    class="collapse"
                                    aria-labelledby="headingOne"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body">
                                        <form
                                            action="{{
                                                route('settings.store')
                                            }}"
                                            method="post"
                                        >
                                            @csrf
                                            <input
                                                type="hidden"
                                                name="name"
                                                value="coc"
                                            />
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    name="data[0]"
                                                    placeholder="add coc"
                                                    class=""
                                                />
                                                <input
                                                    type="submit"
                                                    value="Save"
                                                    class="btn btn-success"
                                                />
                                            </div>
                                        </form>
                                        {{ $coc }}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link collapsed"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapseTwo"
                                            aria-expanded="false"
                                            aria-controls="collapseTwo"
                                        >
                                            Collapsible Group Item #2
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapseTwo"
                                    class="collapse"
                                    aria-labelledby="headingTwo"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim
                                        eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia
                                        aute, non cupidatat skateboard dolor
                                        brunch. Food truck quinoa nesciunt
                                        laborum eiusmod. Brunch 3 wolf moon
                                        tempor, sunt aliqua put a bird on it
                                        squid single-origin coffee nulla
                                        assumenda shoreditch et. Nihil anim
                                        keffiyeh helvetica, craft beer labore
                                        wes anderson cred nesciunt sapiente ea
                                        proident. Ad vegan excepteur butcher
                                        vice lomo. Leggings occaecat craft beer
                                        farm-to-table, raw denim aesthetic synth
                                        nesciunt you probably haven't heard of
                                        them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link collapsed"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#collapseThree"
                                            aria-expanded="false"
                                            aria-controls="collapseThree"
                                        >
                                            Collapsible Group Item #3
                                        </button>
                                    </h2>
                                </div>
                                <div
                                    id="collapseThree"
                                    class="collapse"
                                    aria-labelledby="headingThree"
                                    data-parent="#accordionExample"
                                >
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim
                                        eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia
                                        aute, non cupidatat skateboard dolor
                                        brunch. Food truck quinoa nesciunt
                                        laborum eiusmod. Brunch 3 wolf moon
                                        tempor, sunt aliqua put a bird on it
                                        squid single-origin coffee nulla
                                        assumenda shoreditch et. Nihil anim
                                        keffiyeh helvetica, craft beer labore
                                        wes anderson cred nesciunt sapiente ea
                                        proident. Ad vegan excepteur butcher
                                        vice lomo. Leggings occaecat craft beer
                                        farm-to-table, raw denim aesthetic synth
                                        nesciunt you probably haven't heard of
                                        them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
