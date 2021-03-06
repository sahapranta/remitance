@extends('layouts.app') @section('content')
<div class="containe px-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._reportheader')
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-center">
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
                            <!-- <th>প্রণোদনা/নগদ সহায়তার পরিমাণ</th>                             -->
                            <th>প্রণোদনার পরিমাণ</th>                            
                            <th>পরিশোধের তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        {{$spot_cash_rem = 0;}}
                        {{$spot_cash_inc = 0;}}
                        {{$coc_rem = 0;}}
                        {{$coc_inc = 0;}}
                        {{$qremit_rem = 0;}}
                        {{$qremit_inc = 0;}}
                        {{$agent_rem = 0;}}
                        {{$agent_inc = 0;}}
                        {{$api_rem = 0;}}
                        {{$api_inc = 0;}}
                        @endphp

                        @php($data_index = 0)
                        
                        @foreach($remitances as $remitance)
                            @if($remitance->payment_by !=='agent' && $remitance->payment_type === 'cash' && $remitance->remit_type === 'spotcash')                                
                                <tr>
                                    <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                                    <td>{{$remitance->Customer->name}}</td>
                                    <td>{{$remitance->Customer->identification}}</td>
                                    <td>{{$remitance->sender}}</td>
                                    <td>{{$remitance->exchange_house}}</td>
                                    @if($remitance->payment_date === date('Y-m-d', $date))
                                    <td>{{$remitance->payment_date}}</td>
                                    <td>{{number_format($remitance->amount, 2)}}</td>
                                    @php($spot_cash_rem += $remitance->amount)                            
                                    @else
                                    <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                                    <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                                    @endif
                                    <td class="text-uppercase">
                                        {{$remitance->remit_type}}
                                    </td>
                                    @if($remitance->incentive_date === date('Y-m-d', $date))
                                    <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                                    <td>{{$remitance->incentive_date}}</td>
                                    @php($spot_cash_inc += $remitance->incentive_amount)
                                    @else
                                    <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                                    <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                                    @endif
                                </tr>                                
                            @endif
                        @endforeach                                                

                        @foreach($remitances as $remitance)
                        @if($remitance->payment_by !== 'agent' && $remitance->remit_type === 'coc' && $remitance->payment_type === 'cash')
                        <tr>
                            <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            @if($remitance->payment_date === date('Y-m-d', $date))
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            @php($coc_rem += $remitance->amount)
                            @else
                            <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                            <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                            @endif
                            <td class="text-uppercase">
                                {{$remitance->remit_type}}
                            </td>
                            @if($remitance->incentive_date === date('Y-m-d', $date))
                            <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($coc_inc += $remitance->incentive_amount)
                            @else
                            <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                            <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach

                        @foreach($remitances as $remitance)
                        @if($remitance->remit_type === 'qremit')
                        <tr>
                            <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            @if($remitance->payment_date === date('Y-m-d', $date))
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            @php($remit_rem += $remitance->amount)
                            @else
                            <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                            <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                            @endif
                            <td class="text-uppercase">
                                {{$remitance->remit_type}}
                            </td>
                            @if($remitance->incentive_date === date('Y-m-d', $date))
                            <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($remit_inc += $remitance->incentive_amount)
                            @else
                            <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                            <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach

                        @foreach($remitances as $remitance)
                        @if($remitance->payment_by === 'agent')
                        <tr>
                            <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            @if($remitance->payment_date === date('Y-m-d', $date))
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            @php($agent_rem += $remitance->amount)
                            @else
                            <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                            <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                            @endif
                            <td class="text-uppercase">
                                AGENT
                            </td>
                            @if($remitance->incentive_date === date('Y-m-d', $date))
                            <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($agent_inc += $remitance->incentive_amount)
                            @else
                            <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                            <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach

                        @foreach($remitances as $remitance)
                        @if($remitance->remit_type === 'spotcash' || $remitance->remit_type === 'coc')
                        @if($remitance->payment_type ==='transfer' && $remitance->payment_by === 'branch')
                        <tr>
                            <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            @if($remitance->payment_date === date('Y-m-d', $date))
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            @php($api_rem += $remitance->amount)
                            @else
                            <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                            <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                            @endif
                            <td class="text-uppercase">
                                API A/C
                            </td>
                            @if($remitance->incentive_date === date('Y-m-d', $date))
                            <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($api_inc += $remitance->incentive_amount)
                            @else
                            <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                            <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                            @endif
                        </tr>
                        @endif
                        @endif
                        @endforeach

                        @foreach($remitances as $remitance)
                        @if($remitance->remit_type === 'online')
                        <tr>
                            <td><a href="{{route('remitance.show', $remitance->id)}}">{{$data_index += 1}}</a></td>
                            <td>{{$remitance->Customer->name}}</td>
                            <td>{{$remitance->Customer->identification}}</td>
                            <td>{{$remitance->sender}}</td>
                            <td>{{$remitance->exchange_house}}</td>
                            @if($remitance->payment_date === date('Y-m-d', $date))
                            <td>{{$remitance->payment_date}}</td>
                            <td>{{number_format($remitance->amount, 2)}}</td>
                            @php($online_rem += $remitance->amount)
                            @else
                            <td class="bg-dark text-light">{{$remitance->payment_date}}</td>
                            <td class="bg-dark text-light">{{ number_format(0, 2) }}</td>
                            @endif
                            <td class="text-uppercase">
                                online
                            </td>
                            @if($remitance->incentive_date === date('Y-m-d', $date))
                            <td>{{number_format($remitance->incentive_amount, 2)}}</td>
                            <td>{{$remitance->incentive_date}}</td>
                            @php($online_inc += $remitance->incentive_amount)
                            @else
                            <td class="bg-dark text-light">{{number_format(0, 2)}}</td>
                            <td class="bg-dark text-light">{{ $remitance->incentive_date }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                        <tr class="bg-dark">
                            <td colspan="10"></td>
                        </tr>
                        @foreach($incentives_sum as $incentive)
                        <tr>
                            <td>{{$data_index += 1}}</td>
                            <td>{{$incentive->Customer->name}}</td>
                            <td>{{$incentive->Customer->identification}}</td>
                            @php($index = array_search($incentive->customer_id, $incentives, true))
                            <td colspan="4"></td>
                            <td class="text-uppercase">{{$incentives[$index]['remit_type']}}</td>                            
                            <td>{{$incentive->incentive_amount}}</td>                            
                            <td>{{$incentives[$index]['incentive_date']}}</td>                            
                        </tr>
                        @if($incentives[$index]['payment_by'] !=='agent' && $incentives[$index]['payment_type'] === 'cash' && $incentives[$index]['remit_type'] === 'spotcash')
                            @php($spot_cash_inc += $incentive->incentive_amount)
                        @elseif($incentives[$index]['payment_by'] !=='agent' && $incentives[$index]['payment_type'] === 'cash' && $incentives[$index]['remit_type'] === 'coc')
                            @php($coc_inc += $incentive->incentive_amount)
                        @elseif($incentives[$index]['remit_type'] === 'online')
                            @php($online_inc += $incentive->incentive_amount)
                        @elseif($incentives[$index]['remit_type'] === 'qremit')
                            @php($qremit_inc += $incentive->incentive_amount)
                        @elseif($incentives[$index]['payment_by'] === 'agent')
                            @php($agent_inc += $incentive->incentive_amount)
                        @elseif($incentives[$index]['payment_by'] === 'branch' && $incentives[$index]['payment_type'] === 'transfer')
                            @if($incentives[$index]['remit_type'] === 'spotcash' || $incentives[$index]['remit_type'] === 'coc')
                            @php($api_inc += $incentive->incentive_amount)
                            @endif
                        @endif
                        @endforeach                      
                    </tbody>
                </table>
                <hr />
            </div>
            <div class="table-responsive">
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
                            <td>{{ number_format($coc_rem, 2) }}</td>
                            <td>{{ number_format($qremit_rem, 2) }}</td>
                            @php($total_rem = $spot_cash_rem + $api_rem + $agent_rem +
                            $coc_rem + $qremit_rem)
                            <td>{{ number_format($total_rem, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">INC</td>
                            <td>{{ number_format($spot_cash_inc, 2) }}</td>
                            <td>{{ number_format($api_inc, 2) }}</td>
                            <td>{{ number_format($agent_inc, 2) }}</td>
                            <td>{{ number_format($coc_inc, 2) }}</td>
                            <td>{{ number_format($qremit_inc, 2) }}</td>
                            @php($total_inc = $spot_cash_inc + $api_inc + $agent_inc +
                            $coc_inc + $qremit_inc)
                            <td>{{ number_format($total_inc, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td>
                                {{ number_format($spot_cash_rem + $spot_cash_inc, 2) }}
                            </td>
                            <td>{{ number_format($api_rem + $api_inc, 2) }}</td>
                            <td>
                                {{ number_format($agent_rem + $agent_inc, 2) }}
                            </td>
                            <td>
                                {{ number_format($coc_rem + $coc_inc, 2) }}
                            </td>
                            <td>
                                {{ number_format($qremit_rem + $qremit_inc, 2) }}
                            </td>
                            <td>{{ number_format($total_rem + $total_inc, 2) }}</td>
                        </tr>
                        <tr class="border">
                            <td colspan="3">
                                Suspense Adjustment Report Balance:
                            </td>
                            <td>
                                {{ number_format($spot_cash_rem + $api_rem + $agent_rem, 2) }}
                            </td>
                            <td>{{ number_format($coc_rem + $qremit_rem, 2) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <hr />
            </div>
            <div class="table-responsive">
                <table class="table mt-3 col-md-8 borderless" style="border: 1px solid #666;">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center" style="position: relative;">
                                <span style="position:absolute; border: 3px solid #444444; right:15px; padding: 5px; top: 30%;">CASH DEBIT</span>
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
                            <td>{{ number_format($coc_rem, 2) }}</td>
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
                            <td>{{ number_format($coc_inc, 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr style="border-top: 1px solid #666;">
                            <td></td>
                            <td colspan="2">TOTAL</td>
                            <td>
                                                {{
                                number_format(
                                    $spot_cash_rem +
                                    $coc_rem +
                                    $spot_cash_inc +
                                    $coc_inc,
                                    2
                                )
                                }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection