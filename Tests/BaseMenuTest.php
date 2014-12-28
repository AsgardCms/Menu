<?php namespace Modules\Menu\Tests;

use Faker\Factory;
use Illuminate\Support\Str;
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

    public function createMenu($name, $title)
    {
        $data = [
            'name' => $name,
            'primary' => true,
            'en' => [
                'title' => $title,
                'status' => 1,
            ],
        ];

        return $this->menu->create($data);
    }

    /**
     * Create a menu item for the given menu and position
     *
     * @param  int    $menuId
     * @param  int    $position
     * @param  null   $parentId
     * @return object
     */
    protected function createMenuItemForMenu($menuId, $position, $parentId = null)
    {
        $faker = Factory::create();

        $title = implode(' ', $faker->words(3));
        $slug = Str::slug($title);

        $data = [
            'menu_id' => $menuId,
            'position' => $position,
            'parent_id' => $parentId,
            'target' => '_self',
            'module_name' => 'blog',
            'en' => [
                'status' => 1,
                'title' => $title,
                'uri' => $slug,
            ],
            'fr' => [
                'status' => 1,
                'title' => $title,
                'uri' => $slug,
            ],
        ];

        return $this->menuItem->create($data);
    }
}
