<?php namespace Modules\Menu\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Menu\Events\MenuWasCreated' => [
            'Modules\Menu\Events\Handlers\RootMenuItemCreator',
        ],
        'Modules\Menu\Events\MenuItemWasCreated' => [
            'Modules\Menu\Events\Handlers\MakeMenuItemChildOfRoot',
        ],
    ];
}
