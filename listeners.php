<?php

Event::listen('Modules.Menu.Events.MenuWasCreated', 'Modules\Menu\Listeners\RootMenuItemCreator');
Event::listen('Modules.Menu.Events.MenuItemWasCreated', 'Modules\Menu\Listeners\MakeMenuItemChildOfRoot');
