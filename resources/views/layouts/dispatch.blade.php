<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

        <!--begin::Styles -->
        <link rel="stylesheet" href="{{ mix('css/admin/app.css') }}">

        @stack('styles')

        <!--end::Styles -->

        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">

    </head>

    <body
        class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

        <div id="app" class="d-flex flex-grow-1">

            @include('partials.dispatch._layout')

        </div>

        <!-- begin::Scripts -->
        <script>
            let KTAppOptions = {
                "colors": {
                    "state": {
                        "brand": "#5d78ff",
                        "metal": "#c4c5d6",
                        "light": "#ffffff",
                        "accent": "#00c5dc",
                        "primary": "#5867dd",
                        "success": "#34bfa3",
                        "info": "#36a3f7",
                        "warning": "#ffb822",
                        "danger": "#fd3995",
                        "focus": "#9816f4"
                    },
                    "base": {
                        "label": [
                            "#c5cbe3",
                            "#a1a8c3",
                            "#3d4465",
                            "#3e4466"
                        ],
                        "shape": [
                            "#f0f3ff",
                            "#d9dffa",
                            "#afb4d4",
                            "#646c9a"
                        ]
                    }
                }
            };
        </script>
        <script src="{{ mix('js/admin/manifest.js') }}"></script>
        <script src="{{ mix('js/admin/vendor.js') }}"></script>
        <script src="{{ mix('js/admin/app.js') }}"></script>
        <script>
            jQuery(document).ready(function () {
                    @if(session()->has('message'))
                let type = "{{ session()->get('alert-type', 'info') }}";
                switch (type) {
                    case 'info':
                        toastr.info("{{ session()->get('message') }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ session()->get('message') }}");
                        break;

                    case 'success':
                        toastr.success("{{ session()->get('message') }}");
                        break;

                    case 'error':
                        toastr.error("{{ session()->get('message') }}");
                        break;
                }
                @endif
            });
        </script>

    @stack('scripts')

    <!--end::Scripts -->
    </body>

</html>
