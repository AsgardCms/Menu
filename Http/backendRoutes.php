<?php

use Illuminate\Routing\Router;

$router->model('menus', 'Modules\Menu\Entities\Menu');
$router->model('menuitem', 'Modules\Menu\Entities\Menuitem');

$router->group(['prefix' => '/menu'], function () {
    get('menus', ['as' => 'admin.menu.menu.index', 'uses' => 'MenuController@index']);
    get('menus/create', ['as' => 'admin.menu.menu.create', 'uses' => 'MenuController@create']);
    post('menus', ['as' => 'admin.menu.menu.store', 'uses' => 'MenuController@store']);
    get('menus/{menus}/edit', ['as' => 'admin.menu.menu.edit', 'uses' => 'MenuController@edit']);
    put('menus/{menus}', ['as' => 'admin.menu.menu.update', 'uses' => 'MenuController@update']);
    delete('menus/{menus}', ['as' => 'admin.menu.menu.destroy', 'uses' => 'MenuController@destroy']);

    get('menus/{menus}/menuitem', ['as' => 'dashboard.menuitem.index', 'uses' => 'MenuItemController@index']);
    get('menus/{menus}/menuitem/create', ['as' => 'dashboard.menuitem.create', 'uses' => 'MenuItemController@create']);
    post('menus/{menus}/menuitem', ['as' => 'dashboard.menuitem.store', 'uses' => 'MenuItemController@store']);
    get('menus/{menus}/menuitem/{menuitem}/edit', ['as' => 'dashboard.menuitem.edit', 'uses' => 'MenuItemController@edit']);
    put('menus/{menus}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.update', 'uses' => 'MenuItemController@update']);
    delete('menus/{menus}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.destroy', 'uses' => 'MenuItemController@destroy']);
});
