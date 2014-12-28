<?php namespace Modules\Menu\Listeners;

use Laracasts\Commander\Events\EventListener;
use Modules\Menu\Events\MenuItemWasCreated;
use Modules\Menu\Repositories\MenuItemRepository;

class MakeMenuItemChildOfRoot extends EventListener
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function whenMenuItemWasCreated(MenuItemWasCreated $event)
    {
        $root = $this->menuItem->getRootForMenu($event->menuItem->menu_id);

        if ($root->id !== $event->menuItem->id) {
            $event->menuItem->makeChildOf($root);
        }
    }
}
