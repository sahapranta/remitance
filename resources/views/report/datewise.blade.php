@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
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
                        @foreach($period as $date)
                            <tr>
                                <td>{{$date}}</td>
                                <td>{{$daily_spotcash['$date'] ?? ''}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- {{$daily_acpay}} <br>
                {{$daily_coc}} <br>
                {{$daily_spotcash}} <br> -->
            </div>
        </div>
    </div>
</div>
@endsection