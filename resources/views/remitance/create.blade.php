@extends('layouts.app') @section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div
                class="card-header bg-success text-white d-flex justify-content-between"
            >
                <h4>Pay Remitance</h4>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-light mr-2"
                        >Back</a
                    >
                    <a href="{{ route('home') }}" class="btn btn-dark">Home</a>
                </div>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('remitance.store') }}"
                    method="POST"
                    class="p-3"
                >
                    @csrf
                    <input
                        type="hidden"
                        name="customer_id"
                        value="{{ app('request')->input('customer')}}"
                    />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input
                                    type="text"
                                    placeholder="Reference"
                                    class="form-control @error('reference') is-invalid @enderror"
                                    name="reference"
                                    value="{{ old('reference') }}"
                                    required
                                    autocomplete="reference"
                                />
                                @error('reference')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <rmcountry-select :predata="['{{ old('sending_country')}}']" ></rmcountry-select>
                                @error('sending_country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <remitance-select
                        :spotcash="{{
                            json_encode(config('global.spot_cash'))
                        }}"
                        :coc="{{ json_encode(config('global.coc')) }}"
                        :predata="['{{ old('remit_type')}}', '{{old('exchange_house')}}']"
                    ></remitance-select>

                    <div class="form-group">
                        <input
                            type="text"
                            placeholder="Sender Name"
                            class="form-control @error('sender') is-invalid @enderror"
                            name="sender"
                            value="{{ old('sender') }}"
                            required
                            autocomplete="sender"
                        />
                        @error('sender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <remitance-amount
                        :percent="{{ config('global.incentive_percent')[0] }}"
                        :predata="['{{ old('amount')}}', '{{old('incentive_amount')}}']"
                    >
                        @error('incentive_date')    
                        <template v-slot:incentive>
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        </template>
                        @enderror
                    </remitance-amount>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select
                                    placeholder="Payment By"
                                    class="form-control @error('payment_by') is-invalid @enderror"
                                    name="payment_by"
                                    value="{{ old('payment_by') }}"
                                    required
                                >
                                    <option value="Branch"
                                        >Branch | Payment By</option
                                    >
                                    <option value="Agent"
                                        >Agent | Payment By</option
                                    >
                                </select>
                                @error('payment_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select
                                    class="form-control @error('payment_by') is-invalid @enderror"
                                    name="payment_type"
                                >
                                    <option value="Cash"
                                        >Cash | Payment Type</option
                                    >
                                    <option value="Transfer"
                                        >Transfer | Payment Type</option
                                    >
                                </select>
                                @error('payment_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="note" class="form-control" rows="2" placeholder="Any Note or Extra information if you want to keep..." maxlength="250">{{old('note')}}</textarea>
                        <p class="form-text text-muted">Hey! You can only type 250 Charachter.</p>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <input
                                type="reset"
                                value="Reset"
                                class="btn btn-block btn-dark"
                            />
                        </div>
                        <div class="col-md-5 col-6">
                            <input
                                type="submit"
                                value="Submit"
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
