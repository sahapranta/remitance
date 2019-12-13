@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                                        {!! $remitance->incentive_amount > 0 ?
                                        number_format($remitance->incentive_amount,
                                        2) : '<span class="text-danger"
                                            >Not Paid</span
                                        >' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Incentive Payment: </b>
                                        {!! $remitance->incentive_amount > 0 ?
                                        $remitance->incentive_date : '<span
                                            class="text-danger"
                                            >Not Paid</span
                                        >' !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="position: fixed; bottom:0;">
               <small class="text-muted text-right">Generated By: {{auth()->user()->name}} | {{date('D d-M-Y ')}}</small>
            </div>
        </div>
    </div>
</div>
@endsection
