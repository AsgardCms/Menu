<?php

use Illuminate\Routing\Router;

$router->model('menus', 'Modules\Menu\Entities\Menu');
$router->model('menuitem', 'Modules\Menu\Entities\Menuitem');

$router->group(['prefix' => LaravelLocalization::setLocale(), 'before' => 'LaravelLocalizationRedirectFilter|auth.admin|permissions'], function (Router $router) {
    $router->group(['prefix' => Config::get('core::core.admin-prefix').'/menu', 'namespace' => 'Modules\Menu\Http\Controllers'], function (Router $router) {
        $router->resource('menus', 'Admin\MenuController', ['except' => ['show'], 'names' => [
            'index' => 'admin.menu.menu.index',
            'create' => 'admin.menu.menu.create',
            'store' => 'admin.menu.menu.store',
            'edit' => 'admin.menu.menu.edit',
            'update' => 'admin.menu.menu.update',
            'destroy' => 'admin.menu.menu.destroy',
        ]]);

        $router->resource('menus.menuitem', 'Admin\MenuItemController', ['except' => ['show'], 'names' => [
            'index' => 'dashboard.menuitem.index',
            'create' => 'dashboard.menuitem.create',
            'store' => 'dashboard.menuitem.store',
            'edit' => 'dashboard.menuitem.edit',
            'update' => 'dashboard.menuitem.update',
            'destroy' => 'dashboard.menuitem.destroy',
        ]]);
    });
});

$router->group(['prefix' => 'api', 'namespace' => 'Modules\Menu\Http\Controllers'], function (Router $router) {
    $router->resource('media', 'Api\MenuController', ['only' => ['store']]);
    $router->post('menuitem/update', 'Api\MenuItemController@update');
});
