<?php namespace Modules\Menu\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\CreateMenuRequest;
use Modules\Menu\Http\Requests\UpdateMenuRequest;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Repositories\MenuRepository;
use Modules\Menu\Services\MenuRenderer;

class MenuController extends AdminBaseController
{
    /**
     * @var MenuRepository
     */
    private $menu;
    /**
     * @var MenuItemRepository
     */
    private $menuItem;
    /**
     * @var MenuRenderer
     */
    private $menuRenderer;

    public function __construct(
        MenuRepository $menu,
        MenuItemRepository $menuItem,
        MenuRenderer $menuRenderer
    ) {
        parent::__construct();
        $this->menu = $menu;
        $this->menuItem = $menuItem;
        $this->menuRenderer = $menuRenderer;
    }

    public function index()
    {
        $menus = $this->menu->all();

        return view('menu::admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menu::admin.menus.create');
    }

    public function store(CreateMenuRequest $request)
    {
        $this->menu->create($request->all());

        flash(trans('menu::messages.menu created'));

        return redirect()->route('admin.menu.menu.index');
    }

    public function edit(Menu $menu)
    {
        $menuItems = $this->menuItem->allRootsForMenu($menu->id);

        $menuStructure = $this->menuRenderer->renderForMenu($menu->id, $menuItems->nest());

        return view('menu::admin.menus.edit', compact('menu', 'menuStructure'));
    }

    public function update(Menu $menu, UpdateMenuRequest $request)
    {
        $this->menu->update($menu, $request->all());

        flash(trans('menu::messages.menu updated'));

        return redirect()->route('admin.menu.menu.index');
    }

    public function destroy(Menu $menu)
    {
        $this->menu->destroy($menu);

        flash(trans('menu::messages.menu deleted'));

        return redirect()->route('admin.menu.menu.index');
    }
}
