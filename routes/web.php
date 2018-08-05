<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', 'PingController@ping');
$router->post('/login', 'LoginController@login');
