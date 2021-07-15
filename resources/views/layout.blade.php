<!DOCTYPE html>

<html>

<head>

    <title>Laravel</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style type="text/css">

        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);



        body{

            margin: 0;

            font-size: .9rem;

            font-weight: 400;

            line-height: 1.6;

            color: #212529;

            text-align: left;

            background-color: #f5f8fa;

        }

        .navbar-laravel

        {

            box-shadow: 0 2px 4px rgba(0,0,0,.04);

        }

        .navbar-brand , .nav-link, .my-form, .login-form

        {

            font-family: Raleway, sans-serif;

        }

        .my-form

        {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .my-form .row

        {

            margin-left: 0;

            margin-right: 0;

        }

        .login-form

        {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .login-form .row

        {

            margin-left: 0;

            margin-right: 0;

        }

    </style>

</head>

<body>



<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">

    <div class="container">

        <a class="navbar-brand" href="#">Laravel</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>



        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto">

                @guest

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('login') }}">Login</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('register') }}">Register</a>

                    </li>

                @else

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>

                    </li>

                @endguest

            </ul>



        </div>

    </div>

</nav>



@yield('content')



</body>

</html>
