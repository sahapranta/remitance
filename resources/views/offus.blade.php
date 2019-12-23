@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Upload Offus File</div>
                <div class="card-body">
                    <form action="{{route('offus.upload')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="file" accept=".txt"/>
                        </div>
                        <input type="submit" value="Upload" class="btn btn-block btn-outline-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection