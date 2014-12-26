<?php namespace Modules\Menu\Services;

use Modules\Menu\Repositories\MenuItemRepository;

class MenuOrdener
{
    /**
     * Current Menu Item being looped over
     * @var
     */
    protected $menuItem;
    /**
     * @var MenuItemRepository
     */
    private $menuItemRepository;

    /**
     * @param MenuItemRepository $menuItem
     */
    public function __construct(MenuItemRepository $menuItem)
    {
        $this->menuItemRepository = $menuItem;
    }
}
