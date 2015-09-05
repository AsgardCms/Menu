<?php

$router->post('menuitem/update', ['as' => 'api.menuitem.update', 'uses' => 'MenuItemController@update']);
$router->post('menuitem/delete', ['as' => 'api.menuitem.delete', 'uses' => 'MenuItemController@delete']);
