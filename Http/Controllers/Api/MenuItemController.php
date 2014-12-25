<?php namespace Modules\Menu\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Modules\Menu\Services\MenuService;

class MenuItemController
{
    /**
     * @var MenuService
     */
    private $menuService;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(MenuService $menuService, Repository $cache)
    {
        $this->menuService = $menuService;
        $this->cache = $cache;
    }

    /**
     * Update all menu items
     * @param Request $request
     */
    public function update(Request $request)
    {
        $this->cache->tags('menuItems')->flush();

        foreach ($request->all() as $position => $item) {
            $this->menuService->handle($item, $position);
        }
    }
}
