<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon Links & meta -->

    <!-- Goole Fonts Import -->
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- SEO rules -->
    <meta name="keywords" content="{{ $keywords ?? config('app.name')}}">
    <meta name="description" content="{{ $page_description ?? config('app.name')}}">
    <title>{{ $pageTitle ? $pageTitle . " | " . config('app.name')  : "Dashboard | " . config('app.name') }}</title>
    <link rel="shortcut" href="/favicon.ico">

    <!-- Favicon Rules -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    <!-- SlimSelect -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" rel="stylesheet"></link>

    <!-- IcoFont -->
    <link href="{{ asset('vendor/icofont/icofont.min.css') }}" rel="stylesheet">

    <!-- CoreUI Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/coreui/coreui/dist/css/coreui.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/coreui/icons@2.0.0-beta.3/css/all.min.css') }}">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    {{ $styles ?? '' }}
</head>

<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div>
                        @include('layouts.partials.alerts')
                    </div>
                    <div class="fade-in">
                        {{ $slot }}
                    </div>
            </main>
        </div>
    </div>

    <!-- CoreUI JavaScript -->
    <script src="{{ asset('vendor/coreui/coreui/dist/js/coreui.bundle.min.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('vendor/coreui/icons@2.0.1/js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->
    <script src="{{ asset('vendor/coreui/chartjs@2.0.0/dist/js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('vendor/coreui/utils@1.3.1/dist/coreui-utils.js') }}"></script>

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <!-- SlimSelect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js"></script>

    <!-- JQuery Form Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="{{ mix('js/dashboard.js') }}"></script>
    {{ $scripts ?? '' }}
</body>

</html>
