<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'api'], function (Router $router) {
    $router->resource('media', 'Api\MenuController', ['only' => ['store']]);
    $router->post('menuitem/update', 'Api\MenuItemController@update');
});
