@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h4>Remitance Entry</h4>
                    <div>
                        <a href="{{url()->previous()}}" class="btn btn-dark mr-2">Back</a>
                        <a href="{{route('home')}}" class="btn btn-light">Home</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="input-group col-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Upload XLXS</span>
                            </div>
                            <input type="file" class="form-control" placeholder="Reference" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group col-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Add Reference</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Reference" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection