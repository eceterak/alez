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
    <link rel="stylesheet" href="{{ mix('admin/css/master.css') }}">
</head>
<body class="bg-grey-lighter">
    <div class="container mx-auto">
        <nav class="navigator card flex items-center mt-5 bg-teal text-white">
            <ul>
                <li><a href="/" class="bg-teal-darker">{{ config('app.short', 'Alez.pl') }}</a></li>
                <li><a href="{{ route('admin.cities') }}">Miasta</a></li>
                <li><a href="{{ route('admin.rooms') }}">Pokoje</a></li>
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
        <div>
            <div id="breadcrumbs" class="my-4">
                <ul class="flex list-reset">
                    <li><a href="{{ route('admin') }}">Home</a></li>
                    @if(count(Request::segments())) 
                        @for($i = 1; $i < count(Request::segments()); $i++)
                            <li>&nbsp;/&nbsp;{{ ucfirst(Request::segments()[$i]) }}</li>
                        @endfor
                    @endif
                </ul>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>