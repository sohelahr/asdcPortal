<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <!-- plugins:css -->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{env('BACKEND_CDN_URL')}}/images/favicon.png"/>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        {{--header include here--}}
        @include('layouts.admin.header')
        <div class="container-fluid page-body-wrapper">
            {{--sidebar include here--}}
            @include('layouts.admin.sidenav')
            <div class="main-panel">
                {{--main content here--}}
                @yield('content')
                {{--footer include here--}}
                @include('layouts.admin.footer')
            </div>
        </div>
    </div>
    <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.base.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.addons.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/off-canvas.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/hoverable-collapse.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/misc.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/settings.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/todolist.js"></script>

    @yield('jcontent')
</body>
</html>
