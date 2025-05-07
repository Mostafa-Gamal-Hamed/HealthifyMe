<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    @yield('meta')
    <meta name="author" content="HealthifyMe">

    <title>@yield('title')</title>

    <!-- General favicon for all browsers -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/Featherlight.css') }}">
    @yield('style')

    {{-- jQuery --}}
    <script src="{{ asset('js/jQuery.js') }}"></script>
    @yield('jquery')

    {{-- SweetAlert --}}
    <script src="{{ asset('js/sweetAlert.js') }}"></script>
</head>

<body>
