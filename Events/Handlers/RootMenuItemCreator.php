<?php namespace Modules\Menu\Events\Handlers;

use Modules\Menu\Events\MenuWasCreated;
use Modules\Menu\Repositories\MenuItemRepository;

class RootMenuItemCreator
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;

    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function handle(MenuWasCreated $event)
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

        $this->menuItem->create($data);
    }
}
