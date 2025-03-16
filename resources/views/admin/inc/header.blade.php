<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Admin , admin" name="keywords">
    <meta content="Admin pages" name="description">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Icon  -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">

    <!-- Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    @yield('style')

    {{-- Image box --}}
    <link href="{{ asset('admin/css/Featherlight.css') }}" rel="stylesheet">

    {{-- jQuery --}}
    <script src="{{ asset('js/jQuery.js') }}"></script>
    @yield('jquery')
</head>

<body>