<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/menuitem'], function (Router $router) {
    $router->post('/update', [
        'as' => 'api.menuitem.update',
        'uses' => 'MenuItemController@update',
        'middleware' => 'can:menu.menuitem.update',
    ]);
    $router->post('/delete', [
        'as' => 'api.menuitem.delete',
        'uses' => 'MenuItemController@delete',
        'middleware' => 'can:menu.menuitem.destroy'
    ]);
});
