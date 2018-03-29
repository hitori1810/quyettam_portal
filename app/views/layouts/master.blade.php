<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $app_title }} - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300">
        <link rel="shortcut icon" href="{{ URL::asset('public/img/favicon.png') }}">
        
        <!-- Vendor CSS -->
        <link href="{{ URL::asset('public/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">        
            
        <!-- CSS -->
        <link href="{{ URL::asset('public/vendors/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/app.min.2.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/css/styles.css') }}" rel="stylesheet">
        
        <!-- Page specific styles -->
        @yield('styles')
        
        <script type="text/javascript">
            var APP_URL = '{{ URL::to('/') }}';
            var locale = '{{ App::getLocale() }}';
            var Lang = {};  // Js language object
            var cal_date_format = '{{SugarUtil::getDateformat()}}';
            var cal_time_format = '{{SugarUtil::getTimeformat()}}';
        </script>
        
        {{ ViewUtil::renderJsLanguage('app') }}
    </head>
    <body lang="{{ App::getLocale() }}">
        @include('layouts.header')
        
        <section id="main" data-layout="layout-1">
            @include('layouts.sidebar')
            
            @include('layouts.chat')
            
            <section id="content">
                @yield('content')
            </section>
        </section>
        
        @include('layouts.footer')

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>{{ trans('app.spinner_text') }}</p>
            </div>
        </div>
        
        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="public/img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="public/img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="public/img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="public/img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="public/img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
        
        <!-- Javascript Libraries -->
        <script src="{{ URL::asset('public/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        
        <script src="{{ URL::asset('public/vendors/bower_components/flot/jquery.flot.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/flot.curvedlines/curvedLines.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/sparklines/jquery.sparkline.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/Waves/dist/waves.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
        <script src="{{ URL::asset('public/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="{{ URL::asset('public/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js') }}"></script>
        <![endif]-->
        <script src="{{ URL::asset('public/js/date.js') }}"></script>
        <script src="{{ URL::asset('public/js/functions.js') }}"></script>
        <script src="{{ URL::asset('public/js/notification.js') }}"></script>
        <script src="{{ URL::asset('public/js/dialog.js') }}"></script>
        <script src="{{ URL::asset('public/js/app.js') }}"></script>
        
        
        <!-- Page specific scripts -->
        @yield('scripts')
    </body>
</html>