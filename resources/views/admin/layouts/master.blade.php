<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alez.pl - pokoje na wynajem') }}</title>
    <link rel="stylesheet" href="{{ mix('admin/css/app.css') }}">
</head>
<body class="bg-grey-lighter">
    <div class="container mx-auto">
        <nav class="navigator card flex items-center mt-5 bg-teal text-white">
            <ul>
                <li><a href="/" class="bg-teal-darker">{{ config('app.short', 'Alez.pl') }}</a></li>
                <li><a href="{{ route('cities.index') }}">Miasta</a></li>
                <li><a href="{{ route('cities.index') }}">Ogłoszenia</a></li>
                <li><a href="{{ route('cities.index') }}">Użytkownicy</a></li>
            </ul>
            <div class="ml-auto">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="pr-4 text-white">{{ __('Logout') }}</button>
                    </form>
                @endauth
            </div>
        </nav>
        <div class="py-5">
            @yield('content')
        </div>
    </div>
</body>
</html>