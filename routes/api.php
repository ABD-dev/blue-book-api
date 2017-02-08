<?php

use Illuminate\Http\Request;

/* Public routes */
Route::get('/', function(){ return 'Blue Book API v'.env('APP_VERSION', '0.0.0'); });
Route::post('authenticate', 'AuthenticateController@authenticate');

/* Protected routes - need to be authenticated */
Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('/user/me', 'UserController@me');
});
