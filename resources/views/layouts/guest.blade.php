<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased text-gray-500">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 ">
                <div class="pt-8 sm:justify-start sm:pt-0">
                    <div class="inline-block">
                        <img width="200" height="71" src="https://www.evertecinc.com/wp-content/uploads/2020/07/logo-evertec.png">
                    </div>
                    <div class="inline-block text-orange-400 sm:text-4xl font-mono float-right">
                        Coding Challenge
                    </div>
                </div>

                <header class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4 w-max">
                    <a href="/" class="text-blue-600">
                        {{ __('messages.Products') }}
                    </a>
                    &nbsp;|&nbsp;
                    <a href="/orders" class="text-blue-600">
                        {{ __('messages.My_orders') }}
                    </a>
                    &nbsp;|&nbsp;
                    <a href="{{route('orders.all')}}" class="text-blue-600">
                        {{ __('messages.All_orders') }}
                    </a>
                </header>

                @if ($errors->any())
                    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4 max-w-screen-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4 max-w-screen-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
