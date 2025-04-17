@include("user.inc.header")
@include("user.inc.navbar")

{{-- Message --}}
@include('message')

@yield('body')

@include("user.inc.footer")
