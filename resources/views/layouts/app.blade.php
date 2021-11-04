<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ 'ASDC | Student' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/iconfonts/font-awesome/css/all.min.css">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/vendors/css/vendor.bundle.addons.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('public/css/app.css') }}">    
        <link rel="stylesheet" href="{{env('BACKEND_CDN_URL')}}/css/style.css">

        <!-- Scripts -->
        <script src="{{ url('public/js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    
    <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.base.js"></script> 
    <script src="{{env('BACKEND_CDN_URL')}}/vendors/js/vendor.bundle.addons.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/off-canvas.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/hoverable-collapse.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/misc.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/settings.js"></script>
    <script src="{{env('BACKEND_CDN_URL')}}/js/todolist.js"></script>
    <script src="{{ url('public/js/custom.js') }}"></script>
    @yield('jcontent')
</html>
