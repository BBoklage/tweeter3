<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

       
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 left-side-blue"></div>
                <div class="flex-center position-ref full-height col-md-6 display-flex">
                    @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <ul>
                                    <li>
                                        <a class="landing-link" href="{{ url('/home') }}">Home</a>
                                    </li>
                                @else
                                    <li>
                                        <a class="landing-link" href="{{ route('login') }}">Login</a>
                                    </li>
                                @if (Route::has('register'))
                                    <li>
                                            <a class="landing-link" href="{{ route('register') }}">Register</a>
                                    </li>
                                </ul>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </body>
</html>
