<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=12.0, minimum-scale=.25, user-scalable=yes'>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

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

        <div id="app">

            <main>

                <article>

                    <div class="services-wrapper">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="text-center"><img src="{{ asset('images/logo.png') }}" class="img-fluid logo" alt="logo"></div>
                                    <h3 class="text-center">Welcome to Jollof.com</h3>
                                    <div>
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/4glqT42L6SI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                    <h3 class="text-center">Launching Soon</h3>
                                </div>
                            </div>

                        </div>
                    </div>
                </article>
            </main>

        </div>

    </body>
</html>
