@extends('layouts.app')
 @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <img
                        src="{{ asset('image/logo.png') }}"
                        alt="logo"
                        class="img-fluid pl-5 pr-2"
                    />
                </div>
                <div class="col-md-10">
                    <h1>AGRANI BANK LIMITED</h1>
                    <h5>
                        JHALAM BAZAR BRANCH, CUMILLA MOB: 01819-412930,
                        01713-253464
                    </h5>
                </div>
            </div>
            <hr style="border: 1px solid var(--green); border-radius: 5px;" />
            <h5 class="float-right text-muted">
                {{strtoupper($remitance->remit_type)}}
                #{{$remitance->voucher_reference}}
            </h5>
            <h5 style="color:chocolate;">
                Date: {{date('F d, Y', strtotime($remitance->payment_date))}}
            </h5>

            <div class="row ml-4" style="margin-top: 100px">
                <div class="col-6">
                    <div class="table-responsive">
                        <table
                            class="borderless"
                            style="font-size:1.2rem; border-collapse:separate; border-spacing: 0 0.9rem;"
                        >
                            <tbody>
                                <tr>
                                    <td>
                                        <b>NAME:</b>
                                        {{$remitance->Customer->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>IDENTIFICATION:</b>
                                        {{$remitance->Customer->identification}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>MOBILE:</b>
                                        {{$remitance->Customer->mobile}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>REFERENCE:</b>
                                        {{$remitance->reference}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>SENDER NAME:</b>
                                        {{$remitance->sender}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>SENDING COUNTRY:</b>
                                        {{$remitance->sending_country}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <div
                        class="px-4 pt-4 mr-5 mt-4"
                        style="border: 2px solid #000;"
                    >
                        <table class="table">
                            <tr class="borderless">
                                <td><h3>REMITANCE</h3></td>
                                <td><h3>:</h3></td>
                                <td>
                                    <h3>
                                        {{number_format($remitance->amount, 2)}}
                                    </h3>
                                </td>
                            </tr>
                            <tr class="borderless">
                                <td><h3>INCENTIVE</h3></td>
                                <td><h3>:</h3></td>
                                <td>
                                    <h3>
                                        {{number_format($remitance->incentive_amount, 2)}}
                                    </h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3><b>TOTAL</b></h3>
                                </td>
                                <td><h3>:</h3></td>
                                <td>
                                    <h3>
                                        {{number_format(($remitance->amount + $remitance->incentive_amount), 2)}}
                                    </h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="margin-top: 100px">
                <h3 class="text-muted text-center mb-4">অঙ্গীকারনামা</h3>
                <p
                    style="text-align:justify; font-size: 1.1rem; line-height: 2.2em;"
                    class="px-5 mt-2"
                >
                    আমি,
                    <span
                        class="dotted font-weight-bold"
                        >{{$remitance->Customer->name}}</span
                    >
                    এই মর্মে অঙ্গীকার করছি যে, অদ্য
                    <span class="dotted font-weight-bold">{{
                        strtoupper(date("F d, Y"))
                    }}</span>
                    তারিখে 
                    <span
                        class="dotted font-weight-bold"
                        >{{$remitance->exchange_house}}</span>
                         এক্সচেঞ্জ হাউজের রেফারেন্স নং
                    <span
                        class="dotted font-weight-bold"
                        >{{$remitance->reference}}</span
                    >
                    এর বিপরীতে রেমিট্যান্সের টাকা
                    <span
                        class="dotted font-weight-bold"
                        >{{number_format($remitance->amount, 2)}}</span
                    >
                    এর {{ config("global.incentive_percent")[0] }}% হিসেবে
                    <span
                        class="dotted font-weight-bold"
                        >{{number_format($remitance->incentive_amount, 2)}}</span>
                    টাকা প্রণোদনা/নগদ সহায়তা গ্রহণ করিলাম। এক্ষেত্রে প্রাপ্যতার
                    অতিরিক্ত অর্থ গ্রহণ বা অন্য কোনো অনিয়ম পরবর্তীতে পাওয়া গেলে
                    আমার বিরুদ্ধে আইনানুগ ব্যবস্থা গ্রহণ করা যাবে এবং আমি গৃহীত
                    অর্থ ফেরত প্রদানে বাধ্য থাকিব।
                </p>
            </div>
            <div style="margin-top: 100px;" class="float-right mr-5">
                <table class="table borderless">
                    <tr>
                        <td><h5>স্বাক্ষর</h5></td>
                        <td><b>:</b> _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
                    </tr>
                    <tr>
                        <td><h5>নাম</h5></td>
                        <td>
                            <h5><b>:</b> {{$remitance->Customer->name}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td><h5>তারিখ</h5></td>
                        <td>
                            <h5 style="color:chocolate;">
                                <b>:</b> {{$remitance->payment_date}}
                            </h5>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="display_print">
                <p class="text-muted text-right">
                    Generated By: {{auth()->user()->name}} |
                    {{ date("D d-M-Y ") }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
