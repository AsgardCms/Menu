<?php namespace Modules\Menu\Tests;

use Modules\Core\Tests\BaseTestCase;

abstract class BaseMenuTest extends BaseTestCase
{
    /**
     * @var \Modules\Menu\Repositories\MenuRepository
     */
    protected $menu;
    /**
     * @var \Modules\Menu\Repositories\MenuItemRepository
     */
    protected $menuItem;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        /** @var \Illuminate\Console\Application $artisan */
        $artisan = $this->app->make('Illuminate\Console\Application');
        $artisan->call('module:migrate', ['module' => 'Menu']);

        $this->menu = app('Modules\Menu\Repositories\MenuRepository');
        $this->menuItem = app('Modules\Menu\Repositories\MenuItemRepository');
    }

}
