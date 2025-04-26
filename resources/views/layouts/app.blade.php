<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Default Title' }}</title>
    @yield('head_tags')
    @vite('resources/js/app.js')
</head>
<body>
@include('partials.header')

<main>

    @yield('content')
</main>

@include('partials.footer')
</body>
</html>
