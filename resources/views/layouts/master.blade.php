<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=6.0, minimum-scale=.25, user-scalable=yes'>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(!request()->routeIs('myaccount.*') || request()->routeIs('refer.dashboard'))
            <title>@yield('title')</title>
        @endif

        <!-- Styles -->
        <link href="{{ mix('css/user/app.css') }}" rel="stylesheet">
        <style>
            nav.navbar.navbar-expand-lg.navbar-dark ul li a.dropdown-item{
                color: #000000;
            }
        </style>
        @stack('styles')

        @stack('mscripts')

        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PS48RHV8GB"></script>
        <script>

            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-PS48RHV8GB');

        </script>
    </head>
    <body>
        {{ show_notification() }}
        <div id="app">

            <header>
            @if(!request()->routeIs('myaccount.*') && !request()->routeIs('refer.dashboard'))
                @include('partials._header-topbar')

                @include('partials._header-subheader')
            @endif
                @if (request()->routeIs('fashion.*')  && !request()->routeIs('refer.dashboard'))
                    @include('partials._category-menu-mobile')
                @endif

            </header>

            @yield('content')
            @if(!request()->routeIs('myaccount.*') && !request()->routeIs('refer.dashboard'))
                @include('partials._mobilecart')

                @include('partials._footer')
            @endif
        </div>

        {{ show_popup() }}

        @include('user.partials._comingsoon')

        <!-- Scripts -->
        <script src="{{ mix('js/user/manifest.js') }}"></script>
        <script src="{{ mix('js/user/vendor.js') }}"></script>
        <script src="{{ mix('js/user/app.js') }}"></script>
        @stack('scripts')
        <!-- Scripts -->

        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6112b22a649e0a0a5cd07cd0/1fcoh9u4o';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>
