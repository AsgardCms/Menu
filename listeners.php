<?php

Event::listen('Modules.Menu.Events.MenuWasCreated', 'Modules\Menu\Listeners\RootMenuItemCreator');
