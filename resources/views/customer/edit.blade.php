@extends('layouts.app') @section('css')
<script>
    window.onload = () => {
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    };
</script>
@endsection @section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div
                class="card-header bg-success text-white d-flex justify-content-between"
            >
                <h4>Update {{$customer->name}}</h4>
                <a
                    href="{{route('customer.show', $customer->id)}}"
                    class="btn btn-dark"
                    >Back</a
                >
            </div>
            <div class="card-body">
                <form
                    action="{{route('customer.update', $customer->id)}}"
                    method="POST"
                    class="p-3"
                >
                    @csrf @method('PUT')
                    <div class="form-group">
                        <input
                            type="text"
                            placeholder="Name"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name', $customer->name) }}"
                            required
                        />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input
                            type="text"
                            placeholder="Address"
                            class="form-control @error('address') is-invalid @enderror"
                            name="address"
                            value="{{ old('address', $customer->address) }}"
                            required
                        />
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input
                                    type="text"
                                    placeholder="Mobile No."
                                    class="form-control @error('mobile') is-invalid @enderror"
                                    name="mobile"
                                    value="{{ old('mobile', $customer->mobile) }}"
                                    required
                                    autocomplete="mobile"
                                />
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input
                                    type="date"
                                    class="form-control @error('birthdate') is-invalid @enderror"
                                    name="birthdate"
                                    value="{{ old('birthdate', date('Y-m-d', strtotime($customer->birthdate))) }}"
                                    required
                                    autocomplete="birthdate"
                                />
                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                @if(!auth()->user()->role === 1)
                                <input
                                    type="text"
                                    placeholder="National ID."
                                    class="form-control @error('nid') is-invalid @enderror"
                                    name="nid"
                                    value="{{ old('nid', $customer->nid) }}"
                                />
                                @else
                                <input
                                    type="text"
                                    placeholder="National ID."
                                    class="form-control @error('nid') is-invalid @enderror"
                                    name="nid"
                                    value="{{ old('nid', $customer->nid) }}"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="You can not change NID"          
                                    readonly                          
                                />
                                @endif
                                @error('nid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input
                                    type="text"
                                    placeholder="Passport ID."
                                    class="form-control @error('passport_id') is-invalid @enderror"
                                    name="passport_id"
                                    value="{{ old('passport_id', $customer->passport_id) }}"
                                />
                                @error('passport_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input
                                    type="text"
                                    placeholder="Bank Account ID."
                                    class="form-control @error('account_id') is-invalid @enderror"
                                    name="account_id"
                                    value="{{ old('account_id', $customer->account_id) }}"
                                />
                                @error('account_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <a
                                href="{{route('customer.show', $customer->id)}}"
                                class="btn btn-block btn-dark"
                                >Cancel</a
                            >
                        </div>
                        <div class="col-md-5 col-6">
                            <input
                                type="submit"
                                value="Update"
                                class="btn btn-block btn-success"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
