@extends('layouts.app') @section('css')
<style>
    .dotted {
        border-bottom: 2px dashed #525252;
    }
    .display_print {
        display: none;
    }
    @media print {
        .display_print {
            display: block;
            position: fixed;
            bottom: 0;
        }
    }
</style>
@endsection @section('content')
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
                {{strtoupper($remitances[0]->remit_type)}}
                #{{$remitances[0]->incentive_voucher}}
            </h5>
            <h5 style="color:chocolate;">
                Date:
                {{date('F d, Y', strtotime($remitances[0]->payment_date))}}
            </h5>

            <div class="mt-5">
                <div class="table-responsive">
                    <table
                        class="borderless"
                        style="font-size:1.2rem; border-collapse:separate; border-spacing: 0 0.9rem;"
                    >
                        <tbody>
                            <tr>
                                <td>
                                    <b>NAME:</b>
                                    {{$customer->name}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>IDENTIFICATION:</b>
                                    {{$customer->identification}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>MOBILE:</b>
                                    {{$customer->mobile}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5 mx-3">
                <table class="table" style="border:1px solid #000;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sender</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Exchange House</th>
                            <th>Amount</th>
                            <th>Incentive</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($remitances as $remitance)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->reference}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            <td>
                                {{$remitance->remit_type
                                }}-{{$remitance->exchange_house}}
                            </td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td>
                                {{number_format($remitance->incentive_amount, 2)}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td><b>TOTAL</b></td>
                            <td>
                                {{number_format($remitances->sum('incentive_amount'), 2)}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
                        >{{$customer->name}}</span
                    >
                    এই মর্মে অঙ্গীকার করছি যে, অদ্য
                    <span class="dotted font-weight-bold">{{
                        strtoupper(date("F d, Y"))
                    }}</span>
                    তারিখে এক্সচেঞ্জ হাউজের রেফারেন্স নং
                    <span
                        class="dotted font-weight-bold"
                        >{{$remitance->reference}}</span
                    >
                    এর বিপরীতে রেমিট্যান্সের টাকা
                    <span
                        class="dotted font-weight-bold"
                        >{{number_format($remitances->sum('amount'), 2)}}</span
                    >
                    এর <b>{{ config("global.incentive_percent")[0] }}%</b> হিসেবে
                    <span
                        class="dotted font-weight-bold"
                        >{{number_format($remitances->sum('incentive_amount'), 2)}}</span
                    >
                    টাকা প্রণোদনা/নগদ সহায়তা গ্রহণ করিলাম। এক্ষেত্রে প্রাপ্যতার
                    অতিরিক্ত অর্থ গ্রহন বা অন্য কোনো অনিয়ম পরবর্তীতে পাওয়া গেলে
                    আমার বিরুদ্ধে আইনানুগ ব্যবস্থা গ্রহন করা যাবে এবং আমি গৃহীত
                    অর্থ ফেরত প্রদানে বাধ্য থাকিব।
                </p>
            </div>
            <div style="margin-top: 100px;" class="float-right mr-5">
                <table class="table borderless">
                    <tr>
                        <td><h5>স্বাক্ষর</h5></td>
                        <td>: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
                    </tr>
                    <tr>
                        <td><h5>নাম</h5></td>
                        <td>
                            <h5>: {{$remitance->User->name}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td><h5>তারিখ</h5></td>
                        <td>
                            <h5 style="color:chocolate;">
                                : {{$remitance->payment_date}}
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
