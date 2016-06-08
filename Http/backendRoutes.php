<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->bind('menu', function ($id) {
    return app(\Modules\Menu\Repositories\MenuRepository::class)->find($id);
});
$router->bind('menuitem', function ($id) {
    return app(\Modules\Menu\Repositories\MenuItemRepository::class)->find($id);
});

$router->group(['prefix' => '/menu'], function (Router $router) {
    $router->get('menus', ['as' => 'admin.menu.menu.index', 'uses' => 'MenuController@index']);
    $router->get('menus/create', ['as' => 'admin.menu.menu.create', 'uses' => 'MenuController@create']);
    $router->post('menus', ['as' => 'admin.menu.menu.store', 'uses' => 'MenuController@store']);
    $router->get('menus/{menu}/edit', ['as' => 'admin.menu.menu.edit', 'uses' => 'MenuController@edit']);
    $router->put('menus/{menu}', ['as' => 'admin.menu.menu.update', 'uses' => 'MenuController@update']);
    $router->delete('menus/{menu}', ['as' => 'admin.menu.menu.destroy', 'uses' => 'MenuController@destroy']);

    $router->get('menus/{menu}/menuitem', ['as' => 'dashboard.menuitem.index', 'uses' => 'MenuItemController@index']);
    $router->get('menus/{menu}/menuitem/create', ['as' => 'dashboard.menuitem.create', 'uses' => 'MenuItemController@create']);
    $router->post('menus/{menu}/menuitem', ['as' => 'dashboard.menuitem.store', 'uses' => 'MenuItemController@store']);
    $router->get('menus/{menu}/menuitem/{menuitem}/edit', ['as' => 'dashboard.menuitem.edit', 'uses' => 'MenuItemController@edit']);
    $router->put('menus/{menu}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.update', 'uses' => 'MenuItemController@update']);
    $router->delete('menus/{menu}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.destroy', 'uses' => 'MenuItemController@destroy']);
});
