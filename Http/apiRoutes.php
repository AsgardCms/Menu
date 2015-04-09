<?php

$router->post('menuitem/update', 'MenuItemController@update');
$router->post('menuitem/delete', ['as' => 'api.menuitem.delete', 'uses' => 'MenuItemController@delete']);
