<?php

$router->resource('media', 'MenuController', ['only' => ['store']]);
$router->post('menuitem/update', 'MenuItemController@update');
