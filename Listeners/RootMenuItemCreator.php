<?php namespace Modules\Menu\Listeners;

use Laracasts\Commander\Events\EventListener;
use Modules\Menu\Events\MenuWasCreated;
use Modules\Menu\Repositories\MenuItemRepository;

class RootMenuItemCreator extends EventListener
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function whenMenuWasCreated(MenuWasCreated $event)
    {
        $data = [
            'menu_id' => $event->menu->id,
            'position' => 0,
            'is_root' => true,
            'en' => [
                'title' => 'root',
            ],
            'fr' => [
                'title' => 'root',
            ],
        ];

        $menuItem = $this->menuItem->create($data);
        $menuItem->makeRoot();
    }
}
