@extends('layouts.app')
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
                                        <span class="input-group-text bg-dark text-white">Monthly Date Wise Report</span>
                                    </div>                               
                                    <input type="date" value="2019" class="form-control" name="date"> 
                                    <div class="input-group-append">
                                        <input type="submit" value="Submit" class="btn btn-danger">
                                    </div>
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
@endsection