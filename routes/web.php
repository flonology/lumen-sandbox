<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', 'PingController@ping');
$router->post('/login', 'LoginController@login');
$router->post('/register', 'RegisterController@register');

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function() use ($router) {
    $router->get('creds', 'CredsController@listCreds');
    $router->post('creds', 'CredsController@createCred');
    $router->put('creds/{id:\d+}', 'CredsController@updateCred');
});
