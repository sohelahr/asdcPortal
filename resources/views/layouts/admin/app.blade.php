<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{env('BACKEND_CDN_URL')}}/images/logo/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{env('BACKEND_CDN_URL')}}/images/logo/favicon-16x16.png">
        <title>ASDC | Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

        <!-- Styles -->
        @includeIf('layouts.viho.partials.css'){{-- 
        <link rel="stylesheet" href="{{ url('public/css/app.css') }}">     --}}
        <link rel="stylesheet" href="{{url('public/css/custom.css')}}">
        <!-- Scripts -->
        <script src="{{ url('public/js/app.js') }}" defer></script>
    </head>
    <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-sidebar" id="pageWrapper">
      <!-- Page Header Start-->
        @include('layouts.admin.header')
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
            @include('layouts.admin.sidenav')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
      </div>
    </div>
   </body>
    @includeIf('layouts.viho.partials.js')  
    <script src="{{ url('public/js/custom.js') }}"></script>
    @yield('jcontent')
</html>
