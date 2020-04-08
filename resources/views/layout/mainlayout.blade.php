<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layout.partials.head')
        @yield('style')
    </head>
    <body>
        @include('layout.partials.nav')
        @include('layout.partials.header')
        @yield('content')
        @include('layout.partials.footer')
        @include('layout.partials.footer-scripts')
        @yield('script')
    </body>
</html>
