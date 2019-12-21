@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._reportheader')
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <th>ক্রমিক</th>
                            <th colspan="2">প্রণোদনা গ্রাহীতার তথ্য</th>
                            <th>প্রেরণকারী</th>
                            <th colspan="4" class="text-center">
                                রেমিটেন্স সংশ্লিষ্ট তথ্য
                            </th>
                            <th colspan="2">প্রণোদনা সংশ্লিষ্ট তথ্য</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>নাম</th>
                            <th>জাতীয় পরিচয়পত্র</th>
                            <th>নাম</th>
                            <th>এক্সচেঞ্জ হাউজ</th>
                            <th>প্রেরণের তারিখ</th>
                            <th>অর্থের পরিমাণ</th>
                            <th>লেনদেনের ধরণ</th>
                            <th>প্রণোদনা/নগদ সহায়তার পরিমাণ</th>
                            <th>পরিশোধের তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        {{$spot_cash_rem = 0;}}
                        {{$spot_cash_inc = 0;}}
                        {{$coc_cash_rem = 0;}}
                        {{$coc_cash_inc = 0;}}
                        {{$qremit_cash_rem = 0;}}
                        {{$qremit_cash_inc = 0;}}
                        {{$agent_rem = 0;}}
                        {{$agent_inc = 0;}}
                        {{$api_rem = 0;}}
                        {{$api_inc = 0;}}
                        @endphp @foreach($remitances as $remitance)                        
                        @if($remitance->remit_type === 'spotcash' &&
                        $remitance->payment_type === 'cash' && $remitance->payment_by !== 'agent')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td class="text-uppercase">
                                {{$remitance->remit_type}}
                            </td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($spot_cash_rem += $remitance->amount)
                            @php($spot_cash_inc += $remitance->incentive_amount)
                        </tr>
                        @elseif($remitance->remit_type === 'coc' &&
                        $remitance->payment_type === 'cash' && $remitance->payment_by !== 'agent')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td class="text-uppercase">
                                {{$remitance->remit_type}}
                            </td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($coc_cash_rem += $remitance->amount)
                            @php($coc_cash_inc += $remitance->incentive_amount)
                        </tr>
                        @elseif($remitance->remit_type === 'qremit')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td class="text-uppercase">
                                {{$remitance->remit_type}}
                            </td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($qremit_cash_rem += $remitance->amount)
                            @php($qremit_cash_inc +=
                            $remitance->incentive_amount)
                        </tr>
                        @elseif($remitance->payment_by === 'agent')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td>AGENT</td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($agent_rem += $remitance->amount)
                            @php($agent_inc += $remitance->incentive_amount)
                        </tr>
                        @elseif($remitance->remit_type === 'spotcash' || $remitance->remit_type === 'coc' && $remitance->payment_type === 'transfer')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td>API A/C</td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($api_rem += $remitance->amount) @php($api_inc
                            += $remitance->incentive_amount)
                        </tr>
                        @elseif($remitance->remit_type === 'online')
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            <td>Online</td>
                            <td>{{$remitance->incentive_amount}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                        </tr>
                        @endif @endforeach
                    </tbody>
                </table>
                <hr />
                <table class="table table-striped mt-3 col-md-8">
                    <thead class="bg-warning">
                        <tr class="font-weight-bolder">
                            <th></th>
                            <th>Spotcash</th>
                            <th>A/C</th>
                            <th>AGENT</th>
                            <th>COC</th>
                            <th>Q-Remit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">REM</td>
                            <td>{{ number_format($spot_cash_rem, 2) }}</td>
                            <td>{{ number_format($api_rem, 2) }}</td>
                            <td>{{ number_format($agent_rem, 2) }}</td>
                            <td>{{ number_format($coc_cash_rem, 2) }}</td>
                            <td>{{ number_format($qremit_cash_rem, 2) }}</td>
                            @php($total_rem = $spot_cash_rem + $api_rem + $agent_rem + $coc_cash_rem + $qremit_cash_rem)
                            <td>{{ number_format($total_rem, 2)}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">INC</td>
                            <td>{{ number_format($spot_cash_inc, 2) }}</td>
                            <td>{{ number_format($api_inc, 2) }}</td>
                            <td>{{ number_format($agent_inc, 2) }}</td>
                            <td>{{ number_format($coc_cash_inc, 2) }}</td>
                            <td>{{ number_format($qremit_cash_inc, 2) }}</td>
                            @php($total_inc = $spot_cash_inc + $api_inc + $agent_inc + $coc_cash_inc + $qremit_cash_inc)
                            <td>{{ number_format($total_inc, 2)}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td>
                                {{
                                    number_format(
                                        $spot_cash_rem + $spot_cash_inc,
                                        2
                                    )
                                }}
                            </td>
                            <td>{{ number_format($api_rem + $api_inc, 2) }}</td>
                            <td>
                                {{ number_format($agent_rem + $agent_inc, 2) }}
                            </td>
                            <td>
                                {{
                                    number_format(
                                        $coc_cash_rem + $coc_cash_inc,
                                        2
                                    )
                                }}
                            </td>
                            <td>
                                {{
                                    number_format(
                                        $qremit_cash_rem + $qremit_cash_inc,
                                        2
                                    )
                                }}
                            </td>
                            <td>{{number_format($total_rem + $total_inc, 2)}}</td>
                        </tr>
                        <tr class="border">
                            <td colspan="3">
                                Suspense Adjustment Report Balance:
                            </td>
                            <td>{{number_format($spot_cash_rem + $api_rem + $agent_rem, 2)}}</td>
                            <td>{{number_format($coc_cash_rem + $qremit_cash_rem, 2)}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <hr />
                <table
                    class="table mt-3 col-md-8 borderless"
                    style="border: 1px solid #666;"
                >
                    <thead>
                        <tr>
                            <th
                                colspan="7"
                                class="text-center"
                                style="position: relative;"
                            >
                                <span
                                    style="position:absolute; border: 3px solid #444444; right:15px; padding: 5px; top: 30%;"
                                    >CASH DEBIT</span
                                >
                                <h4>AGRANI BANK LTD.</h4>
                                <span>JHALAM BAZAR BRANCH, CUMILLA</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bold">
                            <td></td>
                            <td colspan="3">
                                DEBIT: Sundry Debtor Others BDT126570001
                            </td>
                            <td colspan="2"></td>
                            <td>{{ date("d/m/Y", $date) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">SPOTCASH Remitance</td>
                            <td>{{ number_format($spot_cash_rem, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">COC Remitance</td>
                            <td>{{ number_format($coc_cash_rem, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">SPOTCASH Incentive</td>
                            <td>{{ number_format($spot_cash_inc, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">COC Incentive</td>
                            <td>{{ number_format($coc_cash_inc, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr style="border-top: 1px solid #666;">
                            <td></td>
                            <td colspan="2">TOTAL</td>
                            <td>{{number_format($spot_cash_rem
                                    + $coc_cash_rem
                                    + $spot_cash_inc
                                    + $coc_cash_inc, 2)}}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
