<?php namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Http\Requests\CreateMenuItemRequest;
use Modules\Menu\Http\Requests\UpdateMenuItemRequest;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;
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

        $menuSelect = $this->getMenuSelect($menu->all());

        return view('menu::admin.menuitems.create', compact('menu', 'pages', 'menuSelect'));
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

        $menuSelect = $this->getMenuSelect($menu, $menuItem->id);

        return view('menu::admin.menuitems.edit', compact('menu', 'menuItem', 'pages', 'menuSelect'));
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
     * @param Menu, $menuItemId
     * @return array
     */
    private function getMenuSelect($menu, $menuItemId = null)
    {
        $menus = $menu->all();

        $menuSelect = array();

        foreach($menus as $menuEntity){
            $menuSelect[$menuEntity['name']] = $menuEntity->menuitems()->get();
        }

        return $menuSelect;
    }



    /**
     * @param  Menu                                    $menu
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addMenuId(Menu $menu, FormRequest $request)
    {
        $data = $request->all();

        foreach (\LaravelLocalization::getSupportedLanguagesKeys() as $lang) {
            $uri = $data[$lang]['uri'];
            $data[$lang]['uri'] = ! empty($uri) ? $uri : $this->getUri($data['page_id'], $lang);
        }

        return array_merge($data, ['menu_id' => $menu->id]);
    }

    /**
     * Get uri
     *
     * @param $item
     * @return string
     */
    private function getUri($pageId, $lang)
    {
        $linkPathArray = array();

        array_push($linkPathArray, $this->getPageSlug($pageId, $lang));

        $hasParentItem = true;

        while ($hasParentItem) {
            $pageId = isset($parentItem) ? $parentItem->parent_id : $pageId;

            $parentItem = Menuitem::where('id', '=', $pageId)->first();

            if ($parentItem->is_root != true) {
                if (!empty($parentItem->page_id)) {
                    array_push($linkPathArray, $this->getPageSlug($parentItem->page_id, $lang));
                } else {
                    $parentUri = ! is_null($parentItem->uri) ? $parentItem->uri . '/' . $linkPathArray : $linkPathArray;
                    array_push($linkPathArray, $parentUri);
                }
            }

            $hasParentItem = ! is_null($parentItem->parent_id) ? true : false;
        }

        $parentLinkPath = implode('/', array_reverse($linkPathArray));

        return $parentLinkPath;
    }

    /**
     * Get page slug
     *
     * @params $pageId, $lang
     * @return string
     */
    private function getPageSlug($pageId, $lang)
    {
        return Page::where('id', '=', $pageId)->first()->translate($lang)->slug;
    }
}
