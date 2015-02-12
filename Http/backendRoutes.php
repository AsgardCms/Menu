<?php

use Illuminate\Routing\Router;

$router->model('menus', 'Modules\Menu\Entities\Menu');
$router->model('menuitem', 'Modules\Menu\Entities\Menuitem');

$router->group(['prefix' => '/menu'], function (Router $router) {
    $router->resource('menus', 'MenuController', [
        'except' => ['show'],
        'names' => [
            'index' => 'admin.menu.menu.index',
            'create' => 'admin.menu.menu.create',
            'store' => 'admin.menu.menu.store',
            'edit' => 'admin.menu.menu.edit',
            'update' => 'admin.menu.menu.update',
            'destroy' => 'admin.menu.menu.destroy',
        ]
    ]);

    $router->resource('menus.menuitem', 'MenuItemController', [
        'except' => ['show'],
        'names' => [
            'index' => 'dashboard.menuitem.index',
            'create' => 'dashboard.menuitem.create',
            'store' => 'dashboard.menuitem.store',
            'edit' => 'dashboard.menuitem.edit',
            'update' => 'dashboard.menuitem.update',
            'destroy' => 'dashboard.menuitem.destroy',
        ]
    ]);
});
