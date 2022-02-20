<?php
use App\Libraries\Core;

$router->group(['prefix' => 'api', 'as' => 'api'], function () use ($router) {

    Core::renderRoutes('api', $router);

});