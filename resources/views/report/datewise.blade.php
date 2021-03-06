@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts._reportheader')
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Spotcash</th>
                            <th>A/C Payee</th>
                            <th>Agent</th>
                            <th>COC</th>
                            <th>Q-Remit</th>
                            <th>Online</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total_spotcash = 0;
                        $total_acpay = 0;
                        $total_agent = 0;
                        $total_coc = 0;
                        $total_qremit = 0;
                        $total_online = 0;
                        $grand_total = 0;
                        @endphp
                        @foreach($period as $date)
                        @if(date('D', strtotime($date)) == 'Fri' || date('D', strtotime($date)) == 'Sat')
                        <tr style="background: rgba(255, 222, 224, 0.6);">
                            <td>{{$date}}</td>
                            <td colspan="7">{{date('D', strtotime($date))}}day</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{ $date }}</td>
                            @php
                            $spot = $spotcash[$date] ?? 0;
                            $acp = $acpay[$date] ?? 0;
                            $co = $coc[$date] ?? 0;
                            $qr = $qremit[$date] ?? 0;
                            $on = $online[$date] ?? 0;
                            $ag = $agent[$date] ?? 0;
                            $total = $spot + $acp + $co +$qr + $on + $ag;
                            $total_spotcash += $spot;
                            $total_acpay += $acp;
                            $total_agent += $ag;
                            $total_coc += $co;
                            $total_qremit += $qr;
                            $total_online += $on;
                            $grand_total += $total;
                            @endphp
                            <td>
                                {{ $spot != 0? number_format($spot, 2) : '' }}
                            </td>
                            <td>{{ $acp != 0? number_format($acp, 2) : '' }}</td>
                            <td>{{ $ag != 0? number_format($ag, 2) : '' }}</td>
                            <td>{{ $co != 0? number_format($co, 2) : '' }}</td>
                            <td>{{ $qr != 0? number_format($qr, 2) : '' }}</td>
                            <td>{{ $on != 0? number_format($on, 2) : '' }}</td>

                            <td>
                                {{ $total != 0? number_format($total, 2) : '' }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bolder">
                            <td>Total</td>
                            <td>{{number_format($total_spotcash, 2)}}</td>
                            <td>{{number_format($total_acpay, 2)}}</td>
                            <td>{{number_format($total_agent, 2)}}</td>
                            <td>{{number_format($total_coc, 2)}}</td>
                            <td>{{number_format($total_qremit, 2)}}</td>
                            <td>{{number_format($total_online, 2)}}</td>
                            <td>{{number_format($grand_total, 2)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-block bg-success text-white p-1 text-center">
                <h4 class="mt-4">Total {{$type}} for <small>{{current($period)}}</small> to <small>{{end($period)}}</small> <b>BDT {{number_format($grand_total, 2)}}</b></h4>
            </div>
        </div>
    </div>
</div>
@endsection