@extends('layouts.app') @section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div
                class="card-header bg-success text-white d-flex justify-content-between"
            >
                <h4>Pay Incentive</h4>
                <a href="{{ route('customer.index') }}" class="btn btn-dark"
                    >Back</a
                >
            </div>
            <div class="card-body">
                <form
                    action="{{route('remitance.update', $remitance->id)}}"
                    method="POST"
                >
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="incentive_amount"
                            value="{{ old('incentive_amount', bcdiv(floatval($remitance->amount )* 0.02, 1, 2)) }}"
                            required
                            autofocus
                        />
                    </div>
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="incentive_date"
                            value="{{ old('incentive_date', date('Y-m-d')) }}"
                        />
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
