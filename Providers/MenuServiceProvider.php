<?php namespace Modules\Menu\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Repositories\Cache\CacheMenuDecorator;
use Modules\Menu\Repositories\Cache\CacheMenuItemDecorator;
use Modules\Menu\Repositories\Eloquent\EloquentMenuItemRepository;
use Modules\Menu\Repositories\Eloquent\EloquentMenuRepository;
use Pingpong\Menus\MenuBuilder as Builder;
use Pingpong\Menus\MenuFacade;
use Pingpong\Menus\MenuItem as PingpongMenuItem;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register all online menus on the Pingpong/Menu package
     */
    public function boot()
    {
        $this->registerMenus();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Register class binding
     */
    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Menu\Repositories\MenuRepository',
            function () {
                $repository = new EloquentMenuRepository(new Menu());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new CacheMenuDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Menu\Repositories\MenuItemRepository',
            function () {
                $repository = new EloquentMenuItemRepository(new Menuitem());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new CacheMenuItemDecorator($repository);
            }
        );
    }

    /**
     * Add a menu item to the menu
     * @param Menuitem $item
     * @param Builder $menu
     */
    public function addItemToMenu(Menuitem $item, Builder $menu)
    {
        if ($this->hasChildren($item)) {
            $this->addChildrenToMenu($item->title, $item->items, $menu, ['icon' => $item->icon, 'target' => $item->target]);
        } else {
            if ($item->page) {
                $menu->route(
                    'page',
                    $item->title,
                    ['uri' => $item->page->slug],
                    ['target' => $item->target, 'icon' => $item->icon]
                );
            } else {
                $menu->url(
                    $item->uri ?: $item->url,
                    $item->title,
                    ['target' => $item->target, 'icon' => $item->icon]
                );
            }

        }
    }

    /**
     * Add children to menu under the give name
     *
     * @param string $name
     * @param object $children
     * @param Builder|MenuItem $menu
     */
    private function addChildrenToMenu($name, $children, $menu, $attribs = [])
    {
        $menu->dropdown($name, function (PingpongMenuItem $subMenu) use ($children) {
            foreach ($children as $child) {
                $this->addSubItemToMenu($child, $subMenu);
            }
        }, 0, $attribs);
    }

    /**
     * Add children to the given menu recursively
     * @param Menuitem $child
     * @param PingpongMenuItem $sub
     */
    private function addSubItemToMenu(Menuitem $child, PingpongMenuItem $sub)
    {
        if ($this->hasChildren($child)) {
            $this->addChildrenToMenu($child->title, $child->items, $sub);
        } else {
            $sub->url($child->getItemUrl(), $child->title, 0, ['icon' => $child->icon, 'target' => $child->target]);
            if ($child->page) {
                $sub->route(
                    'page',
                    $child->title,
                    ['uri' => $child->page->slug],
                    ['target' => $child->target, 'icon' => $child->icon]
                );
            } else {
                $sub->url(
                    $child->uri ?: $child->url,
                    $child->title,
                    ['target' => $child->target, 'icon' => $child->icon]
                );
            }
        }
    }

    /**
     * Check if the given menu item has children
     *
     * @param  object $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return $item->items->count() > 0;
    }

    /**
     * Register the active menus
     */
    private function registerMenus()
    {
        if (! $this->app['asgard.isInstalled']) {
            return;
        }
        $menu = $this->app->make('Modules\Menu\Repositories\MenuRepository');
        $menuItem = $this->app->make('Modules\Menu\Repositories\MenuItemRepository');
        foreach ($menu->allOnline() as $menu) {
            $menuTree = $menuItem->getTreeForMenu($menu->id);
            MenuFacade::create($menu->name, function (Builder $menu) use ($menuTree) {
                foreach ($menuTree as $menuItem) {
                    $this->addItemToMenu($menuItem, $menu);
                }
            });
        }
    }
}
