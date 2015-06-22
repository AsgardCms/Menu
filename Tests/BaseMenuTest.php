<?php namespace Modules\Menu\Tests;

use Faker\Factory;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Sidebar\SidebarServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Menu\Providers\MenuServiceProvider;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Repositories\MenuRepository;
use Orchestra\Testbench\TestCase;
use Pingpong\Modules\ModulesServiceProvider;

abstract class BaseMenuTest extends TestCase
{
    /**
     * @var MenuRepository
     */
    protected $menu;
    /**
     * @var MenuItemRepository
     */
    protected $menuItem;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();

        $this->menu = app(MenuRepository::class);
        $this->menuItem = app(MenuItemRepository::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            ModulesServiceProvider::class,
            CoreServiceProvider::class,
            MenuServiceProvider::class,
            LaravelLocalizationServiceProvider::class,
            SidebarServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Eloquent' => Model::class,
            'LaravelLocalization' => LaravelLocalization::class,
        ];
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
        $artisan = $this->app->make(Kernel::class);
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
