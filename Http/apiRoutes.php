<?php

$router->group(['prefix' => '/menuitem'], function () {
    post('/update', [
        'as' => 'api.menuitem.update',
        'uses' => 'MenuItemController@update',
        'middleware' => 'can:menu.menuitem.update',
    ]);
    post('/delete', [
        'as' => 'api.menuitem.delete',
        'uses' => 'MenuItemController@delete',
        'middleware' => 'can:menu.menuitem.destroy'
    ]);
});
