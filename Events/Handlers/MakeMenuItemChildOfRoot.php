<?php namespace Modules\Menu\Events\Handlers;

use Modules\Menu\Events\MenuItemWasCreated;
use Modules\Menu\Repositories\MenuItemRepository;

class MakeMenuItemChildOfRoot
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function handle(MenuItemWasCreated $event)
    {
        $root = $this->menuItem->getRootForMenu($event->menuItem->menu_id);

        if ($root->id !== $event->menuItem->id) {
            $event->menuItem->makeChildOf($root);
        }
    }
}
