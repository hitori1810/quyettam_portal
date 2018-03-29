<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
    {
        // Modified by Hieu Nguyen on 2016-03-15 to expose some common variables into all views   
        $app_title = trans('app.app_title'); 
        $center_name_title = ""; 
        if(Session::has('session')) {
            View::share('complaintCount', 10);
            View::share('ticketCount', 290);         

            $session = Session::get('session');   
//            Session::forget('session');
//            Session::forget('user');    
//            Session::forget('user_preferences');
        } 

        View::share('app_title', $app_title); 
        View::share('center_name_title', $center_name_title); 
        // End Hieu Nguyen      
});


App::after(function($request, $response)
    {
        //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
    {   
        // Modified by Hieu Nguyen on 2016-03-15 to check authenticated user  
        if(!Session::has('session')) { 
            return Redirect::guest('user/login');
            die;
        }
        // End Hieu Nguyen
});


Route::filter('auth.basic', function()
    {
        return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
    {
        if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
    {
        if (Session::token() != Input::get('_token'))
        {
            throw new Illuminate\Session\TokenMismatchException;
        }
});
