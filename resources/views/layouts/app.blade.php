<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Css --}}
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.theme.green.min.css') }}">
        <link href="{{ asset('admin/css/Featherlight.css') }}" rel="stylesheet">

        <!-- Build -->
        <link rel="stylesheet" href="{{asset('build/assets/app-BwHaPEbd.css')}}">
        <script src="{{asset('build/assets/app-CbEvcXly.js')}}"></script>

        {{-- SweetAlert --}}
        <script src="{{ asset('js/sweetAlert.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            {{-- jQuery --}}
            <script src="{{ asset('js/jQuery.js') }}"></script>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- message -->
            @include("message")

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Js --}}
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/js/Featherlight.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    </body>
</html>
