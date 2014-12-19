<?php namespace Modules\Menu\Composers;

use Illuminate\Contracts\View\View;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Repositories\MenuRepository;
use Pingpong\Menus\Builder;
use Pingpong\Menus\Facades\Menu;

class NavigationViewComposer
{
    /**
     * @var MenuRepository
     */
    private $menu;
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuRepository $menu, MenuItemRepository $menuItem)
    {
        $this->menu = $menu;
        $this->menuItem = $menuItem;
    }

    public function compose(View $view)
    {
        foreach ($this->menu->all() as $menu) {
            $menuTree = $this->menuItem->getTreeForMenu($menu->id);

            Menu::create($menu->name, function (Builder $menu) use ($menuTree) {
                foreach ($menuTree as $menuItem) {
                    $menu->add([
                        'url'   =>  $menuItem->uri,
                        'title' =>  $menuItem->title,
                    ]);
                }
            });
        }
    }
}