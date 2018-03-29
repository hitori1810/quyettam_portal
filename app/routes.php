<?php

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the Closure to execute when that URI is requested.
    |
    */

    Route::get('/', function() {
        return Redirect::to('/customer/index');
    });
    Route::get('/home', function() {
        return Redirect::to('/customer/index');
    });

    // Routes that need to be checked for authentication
    Route::group(array('before' => 'auth'), function() {
        Route::get('/home/index', 'HomeController@index');              
        Route::get('/user/changePassword', 'UserController@changePassword');
        Route::post('/user/savePassword', 'UserController@savePassword');                    
        Route::get('/customer/index', 'CustomerController@index');                      
        Route::get('/customer/edit', 'CustomerController@edit');                   
        Route::post('/customer/save', 'CustomerController@save');                   
        Route::get('/payment/index', 'PaymentController@index');                      
        Route::post('/payment/edit', 'PaymentController@edit');                   
        Route::get('/product/index', 'ProductController@index');                      
        Route::post('/product/edit', 'ProductController@edit');                      
    });

    // Routes that dont't need to be checked for authentication
    Route::group(array('after' => 'auth'), function() {
        Route::any('/user/login', 'UserController@login');
        Route::any('/user/logout', 'UserController@logout');
        Route::get('/user/switchLanguage', 'UserController@switchLanguage');
    });