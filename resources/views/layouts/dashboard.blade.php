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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">

    <!-- SlimSelect -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" rel="stylesheet"></link>

    <!-- IcoFont -->
    <link href="{{ asset('vendor/icofont/icofont.min.css') }}" rel="stylesheet">

    <!-- CoreUI Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/coreui/coreui/dist/css/coreui.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/coreui/icons@2.0.0-beta.3/css/all.min.css') }}">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    {{ $styles ?? '' }}
</head>

<body class="c-app">
    @include('layouts.partials.sidebar')
    <div class="c-wrapper c-fixed-components">
        @include('layouts.partials.header')
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div>
                        @include('layouts.partials.alerts')
                    </div>
                    <div class="fade-in">
                        {{ $slot }}
                    </div>
                </div>
            </main>
            @include('layouts.partials.footer')
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
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <!-- JQuery Form Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <!-- SlimSelect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js"></script>

    <!-- LuxonJs -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1/build/global/luxon.min.js"></script>
    <script>
        let DateTime = luxon.DateTime;
    </script>

    <!-- Custom JS -->
    <script src="{{ mix('js/dashboard.js') }}"></script>

    <!-- Pusher Notifications -->
    {{-- <script>
        const notificationCount = document.getElementById('notificationCount');
        const notificationContainer = document.getElementById('notificationContainer');
        const notificationRingtone = new Audio('{{ asset("audio/notification.mp3") }}');

        function createNotificationHTML(id, text, submit_route, action_url) {
            submit_route = submit_route;
            return `<a class="dropdown-item py-2 align-items-start" style="white-space: normal;" href="${submit_route}">
                        <svg class="c-icon mr-2" style="width: 2rem; height: 2rem;">
                            <use xlink:href="{{asset('svg_sprites/free.svg#cil-speech')}}"></use>
                        </svg> <span>${text}</span>
                    </a>`;
        }

        Echo.private("App.Models.User." + '{{ auth()->user()->id }}')
            .notification((notification) => {
                if(Number(notificationCount.innerHTML) != 0){
                    notificationCount.innerHTML = Number(notificationCount.innerHTML) + 1;
                    const prevHtml = notificationContainer.innerHTML;
                    notificationContainer.innerHTML = createNotificationHTML(notification.id, notification.text, notification.submit_route, notification.redirect_url) + notificationContainer.innerHTML;
                } else {
                    notificationCount.classList.remove('d-none');
                    notificationCount.innerHTML = 1;
                    notificationContainer.innerHTML = createNotificationHTML(notification.id, notification.text, notification.submit_route, notification.redirect_url);
                }
                notificationRingtone.pause();
                notificationRingtone.currentTime = 0;
                notificationRingtone.play();
            });

    </script> --}}
    {{ $scripts ?? '' }}
</body>

</html>
