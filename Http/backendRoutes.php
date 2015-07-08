<?php

$router->bind('menu', function ($id) {
    return app(\Modules\Menu\Repositories\MenuRepository::class)->find($id);
});
$router->bind('menuitem', function ($id) {
    return app(\Modules\Menu\Repositories\MenuItemRepository::class)->find($id);
});

$router->group(['prefix' => '/menu'], function () {
    get('menus', ['as' => 'admin.menu.menu.index', 'uses' => 'MenuController@index']);
    get('menus/create', ['as' => 'admin.menu.menu.create', 'uses' => 'MenuController@create']);
    post('menus', ['as' => 'admin.menu.menu.store', 'uses' => 'MenuController@store']);
    get('menus/{menu}/edit', ['as' => 'admin.menu.menu.edit', 'uses' => 'MenuController@edit']);
    put('menus/{menu}', ['as' => 'admin.menu.menu.update', 'uses' => 'MenuController@update']);
    delete('menus/{menu}', ['as' => 'admin.menu.menu.destroy', 'uses' => 'MenuController@destroy']);

    get('menus/{menu}/menuitem', ['as' => 'dashboard.menuitem.index', 'uses' => 'MenuItemController@index']);
    get('menus/{menu}/menuitem/create', ['as' => 'dashboard.menuitem.create', 'uses' => 'MenuItemController@create']);
    post('menus/{menu}/menuitem', ['as' => 'dashboard.menuitem.store', 'uses' => 'MenuItemController@store']);
    get('menus/{menu}/menuitem/{menuitem}/edit', ['as' => 'dashboard.menuitem.edit', 'uses' => 'MenuItemController@edit']);
    put('menus/{menu}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.update', 'uses' => 'MenuItemController@update']);
    delete('menus/{menu}/menuitem/{menuitem}', ['as' => 'dashboard.menuitem.destroy', 'uses' => 'MenuItemController@destroy']);
});
