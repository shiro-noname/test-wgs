<?php

/* registration */
$router->post('/register', [ 'as' => 'register', 'uses' => 'AuthController@register']);

/* login */
$router->post('/auth/login', [ 'as' => 'login', 'uses' => 'AuthController@login']);

/* restrict route */
$router->group(['middleware' => 'auth'], function () use ($router) {

    /* get user profile */
    $router->get('/auth/profile', [ 'as' => 'profile', 'uses' => 'AuthController@profile']);

    /* logout user */
    $router->get('/auth/logout', [ 'as' => 'logout', 'uses' => 'AuthController@logout']);

    /* refresh token */
    $router->get('/auth/refresh-token', [ 'as' => 'refreshToken', 'uses' => 'AuthController@refresh']);


});