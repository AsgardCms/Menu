<?php namespace Modules\Menu\Tests;

use Faker\Factory;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

abstract class BaseMenuTest extends TestCase
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

        $this->resetDatabase();

        $this->menu = app('Modules\Menu\Repositories\MenuRepository');
        $this->menuItem = app('Modules\Menu\Repositories\MenuItemRepository');
    }

    protected function getPackageProviders($app)
    {
        return ['Modules\Menu\Providers\MenuServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return ['Eloquent' => 'Illuminate\Database\Eloquent\Model'];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
    }

    private function resetDatabase()
    {
        // Relative to the testbench app folder: vendors/orchestra/testbench/src/fixture
        $migrationsPath = 'Database/Migrations';
        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');
        // Makes sure the migrations table is created
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
        // We empty all tables
        $artisan->call('migrate:reset', [
            '--database' => 'sqlite',
        ]);
        // Migrate
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
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
