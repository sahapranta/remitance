@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="/css/daterangepicker.min.css">
<script>
    function make_script(link) {
        let script = document.createElement("script");
        script.src = link;
        document.body.appendChild(script);
    }
    window.onload = () => {
        make_script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js');
        make_script('/js/jquery.daterange.js');
        setTimeout(() => {
            $('.daterange').dateRangePicker({
                autoClose: true,
                singleMonth: 'auto',
                showTopbar: false,
                showShortcuts: true,
                endDate: moment(new Date()).format('YYYY-MM-DD'),
                shortcuts: {
                    'prev-days': [3, 5, 7],
                    'prev': ['week', 'month'],
                    'next-days': null,
                    'next': null
                },
                getValue: function() {
                    if ($('#daterange').val() && $('#daterange2').val())
                        return $('#daterange').val() + ' to ' + $('#daterange2').val();
                    else
                        return '';
                },
                setValue: function(s, s1, s2) {
                    $('#daterange').val(s1);
                    $('#daterange2').val(s2);
                }
            });
        }, 300);
    }
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success d-flex justify-content-between">
                    <h4 class="text-white">Generate Report</h4>
                    <div class="">
                        <a href="{{url()->previous()}}" class="btn btn-light mr-2">Back</a>
                        <a href="{{ route('home') }}" class="btn btn-dark">Home</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header font-weight-bold">Monthly / Daily Report</div>
                                <div class="card-body">                                    
                                    <form method="get">
                                        <div class="form-group">
                                            <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="date">
                                        </div>
                                        <div class="btn-group btn-block">
                                            <input type="submit" value="Monthly" class="btn btn-outline-dark" formaction="{{route('report.monthly')}}">
                                            <input type="submit" value="Daily" class="btn btn-dark" formaction="{{route('report.daily')}}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header font-weight-bold">DateWise Remitance / Incentive</div>
                                <div class="card-body">
                                    <form method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" id="daterange" class="form-control daterange" name="startdate" placeholder="Select Date">
                                            <input type="text" id="daterange2" class="form-control daterange" name="enddate" placeholder="Range">
                                        </div>
                                        <div class="btn-group btn-block">
                                            <input type="submit" value="Remitance" class="btn btn-outline-primary" formaction="{{route('report.date.remitance')}}">
                                            <input type="submit" value="Incentive" class="btn btn-primary" formaction="{{route('report.date.incentive')}}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header font-weight-bold">Re-Print Incentive Voucher</div>
                                <div class="card-body">
                                    <form action="" method="get">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Incentive Voucher Number" name="voucher" required />
                                            <input type="text" class="form-control col-3" placeholder="ID" name="customer" required/>
                                        </div>
                                        <div class="btn-group btn-block">
                                            <input type="reset" value="Reset" class="btn btn-outline-danger" >
                                            <input type="button" value="Submit" class="btn btn-danger">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection