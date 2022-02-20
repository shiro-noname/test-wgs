<?php

/* Products group */
$router->group(['middleware' => 'auth'], function () use ($router) {

    /* GET All Products */
    $router->get('items', [ 'as' => 'all', 'uses' => 'ProductController@all']);

    $router->group(['prefix' => 'item', 'as' => 'item'], function () use ($router) {

        /* Product Create */
        $router->post('/add', [ 'as' => 'add', 'uses' => 'ProductController@store']);

        /* Product Update */
        $router->post('/update', [ 'as' => 'update', 'uses' => 'ProductController@update']);

        /* Product Delete */
        $router->post('/delete', [ 'as' => 'delete', 'uses' => 'ProductController@delete']);

        /* Product Search */
        $router->post('/search', [ 'as' => 'search', 'uses' => 'ProductController@showBySku']);

    });


});