<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agrani Bank Incentive Solution</title>
        <link rel="shortcut icon" href="image/logo.png" type="image/x-icon">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-dark">
        <div class="container-fluid">
                @if (Route::has('login'))
                <div class="row p-5  mt-3 text-center">
                    <div class="col-8 offset-2">
                        <img src="image/agrani_bank.jpg" alt="image" class="img-fluid mt-5">
                        <h1 class="mt-4 text-white">
                            Jhalam Bazar Branch, Cumilla
                        </h1>
                    </div>
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-light btn-block col-6 mt-4">Home</a>
                    @else
                        <div class="col-4 offset-2 mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login</a>
                        </div>
                        <div class="col-4 mt-4">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light btn-block">Register</a>
                        @endif
                        </div>
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>
