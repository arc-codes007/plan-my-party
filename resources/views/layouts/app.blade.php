<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
    <meta name="auth-token" content="{{ Auth::user()->api_token }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        @auth
            $.ajaxSetup({
                headers: {
                    'Authorization': 'Bearer '+$('meta[name="auth-token"]').attr('content')
                },
            });
        @endauth
    </script>
    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div>
        @include('components.navbar')
        <main class="pb-4" style="padding-top:3.5rem">
            @yield('content')
        </main>
    </div>
@include('components.package_view_modal');

</body>
</html>
