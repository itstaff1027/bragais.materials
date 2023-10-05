<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            top: 0;
            left: 0;
            margin: 0;
        }

        .welcome_container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            background-color: #1d0721;
        }

        .welcome_content {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 150px;
            background-color: #44114f;
            border-radius: 150px;
            box-shadow: 0 0 10px #6f277f, 0 0 15px #9a42ae, 0 0 20px #b945d3, 0 0 25px #b62bd5, 0 0 35px #a508c9;
            transition: 0s;
        }

        .welcome_content:hover {
            transition: 1s;
            box-shadow: 0 0 100px #5c1e6a, 0 0 150px #7e2792, 0 0 200px #871c9f, 0 0 250px #791191, 0 0 350px #640679;
        }

        .welcome_login_btn {
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
            color: white;
        }
    </style>
</head>

<body>
    <div class="welcome_container">
        @if (Route::has('login'))

        @auth
        <a href="{{ url('/dashboard') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="welcome_login_btn">
            <div class="welcome_content">
                LOGIN
            </div>
        </a>
        {{-- @if (Route::has('register')) --}}
        {{-- <a href="{{ route('register') }}"
            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
        --}}
        {{-- @endif --}}
        @endauth

        @endif
    </div>
</body>

</html>