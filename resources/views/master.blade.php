<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title')</title>

    @include('partials._head')
</head>

<body class="">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900" x-data="data()">
        <!-- Desktop sidebar -->
        @include('partials._aside')

        <!-- Mobile sidebar -->
        @include('partials._mobile-aside')
        <div class="flex flex-col flex-1 w-full">
            @include('partials._main-nav')

            @yield('content')
        </div>
    </div>

    <!-- Footer script -->
    <script src="{{ asset('js/init-alpine.js') }}"></script>
    @yield('footer-script')
</body>

</html>