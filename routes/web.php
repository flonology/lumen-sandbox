<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', 'PingController@ping');
$router->post('/login', 'LoginController@login');

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function() use ($router) {
    $router->get('creds', 'PingController@ping');
});
