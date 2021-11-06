<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        @yield('title')

        <link rel="stylesheet" href="{{ url('public/css/app.css') }}">    


        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/iconfonts/font-awesome/css/all.min.css">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/css/style.css">
        <link rel="shortcut icon" href="{{env('BACKEND_CDN_URL')}}/images/favicon.png"/>
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/css/custom.css">

        <script src="{{ url('public/js/app.js') }}" defer></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        @yield('content')
        <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.base.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.addons.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/js/off-canvas.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/js/hoverable-collapse.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/js/misc.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/js/settings.js"></script>
        <script src="{{env('BACKEND_CDN_URL')}}/js/todolist.js"></script>
        <script src="{{ url('public/js/custom.js') }}"></script>
        @yield('jcontent')
    </body>
</html>
