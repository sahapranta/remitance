@extends('layouts.app') @section('content')
<div class="container">
    <div class="justify-content-center">
        @include('layouts._message')
        <div class="card">
            <div
                class="card-header bg-dark text-white d-flex justify-content-between"
            >
                <h4>
                    Remitance for
                    <a
                        class="text-white border-bottom border-info"
                        href="{{route('customer.show', $remitance->Customer->id)}}"
                        >{{$remitance->Customer->name}}</a
                    >
                    @unless($remitance->incentive_amount > 0)
                    <span class="badge badge-pill badge-danger">Due</span>
                    @endunless
                </h4>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-light mr-2"
                        >Back</a
                    >
                    <a href="{{ route('home') }}" class="btn btn-success"
                        >Home</a
                    >
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Reference: </b>#
                                            {{$remitance->reference}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Payment Date: </b>
                                            <i class="fa fa-clock-o"></i>
                                            {{$remitance->payment_date}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Sending Country: </b>
                                            {{$remitance->sending_country}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Sender: </b>
                                            {{$remitance->sender}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Remitance Type:</b>
                                            {{$remitance->remit_type}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Exchange House:</b>
                                            {{$remitance->exchange_house}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Payment By:</b>
                                            {{$remitance->payment_by}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Payment Type:</b>
                                            {{$remitance->payment_type}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Total Paid: </b>
                                            <span
                                                class="text-danger"
                                                >{{number_format($remitance->amount + $remitance->incentive_amount, 2)}}</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Amount: </b>
                                            <span
                                                class="text-danger"
                                                >{{number_format($remitance->amount, 2)}}</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Incentive Amount: </b>
                                            {!! $remitance->incentive_amount > 0
                                            ?
                                            number_format($remitance->incentive_amount,
                                            2) : '<span class="text-danger"
                                                >Not Paid</span
                                            >' !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Incentive Payment: </b>
                                            {!! $remitance->incentive_amount > 0
                                            ? $remitance->incentive_date :
                                            '<span class="text-danger"
                                                >Not Paid</span
                                            >' !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a
                    href=""
                    class="btn btn-outline-success col-md-1 mr-2"
                    title="You Have No Permission"
                    >Edit</a
                >
                <a
                    href="{{route('remitance.edit', $remitance->id)}}"
                    class="btn btn-primary col-md-2"
                    >Pay Incentive</a
                >
                <div class="float-right">
                    <a href="{{route('report.remitance', $remitance->id)}}" class="btn btn-outline-dark">Print</a>
                    <a href="{{route('report.remitance-sms', $remitance->id)}}" class="btn btn-outline-danger">SMS</a>
                </div>
                <p class="text-muted mt-3 border-top text-right">
                    By - {{$remitance->User->name}}
                    <i class="fa fa-clock-o"></i> {{$remitance->payment_date}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
