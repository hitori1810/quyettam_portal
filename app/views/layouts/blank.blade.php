<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ trans('app.app_title') }} - @yield('title')</title>
        <link rel="shortcut icon" href="{{ URL::asset('public/img/favicon.png') }}">

        <!-- Vendor CSS -->
        <link href="{{ URL::asset('public/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css') }}" rel="stylesheet">

        <!-- Page specific styles -->
        @yield('styles')
        
        <script type="text/javascript">
            var APP_URL = '{{ URL::to('/') }}';
            var Lang = {};  // Js language object
        </script>
    </head>
    <body>
        
        @yield('content')

        <!-- Vendor JS -->
        <script src="{{ URL::asset('public/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
        <script src="{{ URL::asset('public/js/notification.js') }}"></script>
        <script src="{{ URL::asset('public/js/dialog.js') }}"></script>
        
        <!-- Page specific scripts -->
        @yield('scripts')
    </body>
</html>