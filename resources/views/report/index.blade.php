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
                endDate:moment(new Date()).format('YYYY-MM-DD'),                
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
                    <div class="d-block">
                        <div class="form-group row">
                            <form action="{{route('report.monthly')}}" method="post" class="col-md-6">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-white">Monthly Total Report</span>
                                    </div>
                                    <input type="date" value="2019" class="form-control" name="date">
                                    <div class="input-group-append">
                                        <input type="submit" value="Submit" class="btn btn-danger">
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('report.monthly.full')}}" method="post" class="col-md-6">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-white">Date Wise Report</span>
                                    </div>
                                    <input type="text" id="daterange" class="form-control daterange" name="startdate" placeholder="Select Date">
                                    <input type="text" id="daterange2" class="form-control daterange" name="enddate" placeholder="Range">
                                    <div class="input-group-append">
                                        <input type="submit" value="Submit" class="btn btn-danger">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{route('report.daily')}}" class="btn btn-primary">Daily Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection