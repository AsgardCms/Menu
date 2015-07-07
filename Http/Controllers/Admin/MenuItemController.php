<?php namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Http\Requests\CreateMenuItemRequest;
use Modules\Menu\Http\Requests\UpdateMenuItemRequest;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Repositories\PageRepository;

class MenuItemController extends AdminBaseController
{
    /**
     * @var MenuItemRepository
     */
    private $menuItem;
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(MenuItemRepository $menuItem, PageRepository $page)
    {
        parent::__construct();
        $this->menuItem = $menuItem;
        $this->page = $page;
    }

    public function create(Menu $menu)
    {
        $pages = $this->page->all();

        return view('menu::admin.menuitems.create', compact('menu', 'pages'));
    }

    public function store(Menu $menu, CreateMenuItemRequest $request)
    {
        $this->menuItem->create($this->addMenuId($menu, $request));

        flash(trans('menu::messages.menuitem created'));

        return redirect()->route('admin.menu.menu.edit', [$menu->id]);
    }

    public function edit(Menu $menu, Menuitem $menuItem)
    {
        $pages = $this->page->all();

        return view('menu::admin.menuitems.edit', compact('menu', 'menuItem', 'pages'));
    }

    public function update(Menu $menu, Menuitem $menuItem, UpdateMenuItemRequest $request)
    {
        $this->menuItem->update($menuItem, $this->addMenuId($menu, $request));

        flash(trans('menu::messages.menuitem updated'));

        return redirect()->route('admin.menu.menu.edit', [$menu->id]);
    }

    public function destroy(Menu $menu, Menuitem $menuItem)
    {
        $this->menuItem->destroy($menuItem);

        flash(trans('menu::messages.menuitem deleted'));

        return redirect()->route('admin.menu.menu.edit', [$menu->id]);
    }

    /**
     * @param  Menu                                    $menu
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addMenuId(Menu $menu, FormRequest $request)
    {
        return array_merge($request->all(), ['menu_id' => $menu->id]);
    }
}
