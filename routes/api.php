<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', ['middleware' => 'cors'], function (Router $api) {

    $api->get('/', function(){
      return response()->json([
        'message' => 'Blue Book Api '.env('API_VERSION')
      ]);
    });

    $api->post('authenticate', 'App\\Http\\Controllers\\AuthenticateController@authenticate');

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {

      $api->group(['prefix' => 'user'], function(Router $api) {
        $api->get('me', 'App\\Http\\Controllers\\UserController@me');
      });

    });

});
