@extends('layouts.blank')

@section('title', trans('app.page_title'))

@section('styles')
<link href="{{ URL::asset('public/css/user_login.css') }}" rel="stylesheet">     
@stop

@section('content')   
<div id = "login_content">
    <div id="wrapper">
        <div id="header">
            <h1>{{ trans('app.app_title') }}</h1>
            <ul id="lang-chooser">
                <li class="lang-en @if(App::getLocale() == 'en') active @endif">
                    <a href="{{ URL::to('user/switchLanguage') }}?lang=en" hreflang="en" title="English"><span>English</span></a>
                </li>
                <li class="lang-vi @if(App::getLocale() == 'vi') active @endif">
                    <a href="{{ URL::to('user/switchLanguage') }}?lang=vi" hreflang="vi" title="Tiếng Việt"><span>Tiếng Việt</span></a>
                </li>
            </ul>
        </div>
        <div id="content" class="round10">
            <div id="login" class="round10">
                <form name="form-login" action="" method="post">
                    <table cellpadding="5" cellspacing="5">
                        <tr>
                            <td class="label" width="140">{{ trans('user_login.customer_id') }}</td>
                            <td><input type="text" id="username" name="username" value="{{ $username }}"/></td>
                        </tr>
                        <tr>
                            <td class="label">{{ trans('user_login.password') }}</td>
                            <td><input type="password" id="password" name="password" value="{{ $password }}"/></td>
                        </tr>
                        <tr>
                            <td class="label"></td>
                            <td><label><input type="checkbox" id="remember_me" name="remember_me" value="1"/> {{ trans('user_login.remember_me') }}</label></td>
                        </tr>
                        <tr>
                            <td class="label"></td>
                            <td><input type="submit" id="submit" name="submit" value="{{ trans('user_login.login') }}"/></td>
                        </tr>    
                    </table>

                    <div class="error">
                        @if($result == 'not_for_portal')
                        {{ trans('user_login.account_is_not_a_customer_error_msg') }}
                        @elseif($result == 'login_failed')
                        {{ trans('user_login.login_failed_error_msg') }}
                        @endif
                    </div>
                </form>
            </div>
            <div id="about" class="round10">
                <div id="logo">
                    <img src="{{ URL::asset('/public/img/logo.png') }}" alt="Trung tâm ngoại ngữ 5 sao Atlantic" style="width: 320px; height: auto;"/>
                </div>  
                <div id="description">

                </div>
            </div> 
            <div id="contact" class="round10">
                {{ trans('user_login.description') }}                    
            </div>
            <div class="clear"></div>
        </div>        
    </div>
</div>
<div id="footer">
    @include('layouts.footer')
    </div>
@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('user_login') }}

    <script src="{{ URL::asset('public/js/user_login.js') }}"></script>
     
@stop