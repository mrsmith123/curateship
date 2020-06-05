<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('meta') {{-- Meta tags stack --}}
        <title>@yield('title', 'Admin Module')</title>

         <script>
            if('CSS' in window && CSS.supports('color', 'var(--color-var)')) {
                document.write('<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">');
            } else {
                document.write('<link rel="stylesheet" href="{{ asset('assets/css/style-fallback.css') }}">');
            }
        </script>
        <noscript>
            <link rel="stylesheet" href="{{ asset('assets/css/style-fallback.css') }}">
        </noscript>
        @stack('styles') {{-- Styles stack --}}
    </head>
    <body>
        <div class="container max-width-sm">
            @yield('content')
        </div>
        
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        @stack('scripts') {{-- Scripts stack --}}
    </body>
</html>
