<?php namespace Modules\Menu\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Services\MenuOrdener;

class MenuItemController extends Controller
{
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var MenuOrdener
     */
    private $menuOrdener;

    public function __construct(MenuOrdener $menuOrdener, Repository $cache)
    {
        $this->cache = $cache;
        $this->menuOrdener = $menuOrdener;
    }

    /**
     * Update all menu items
     * @param Request $request
     */
    public function update(Request $request)
    {
        $this->cache->tags('menuItems')->flush();

        $this->menuOrdener->handle($request->get('menu'));
    }
}
