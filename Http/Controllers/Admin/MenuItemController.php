<?php

namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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

        $menuSelect = $this->getMenuSelect($menu);

        return view('menu::admin.menuitems.create', compact('menu', 'pages', 'menuSelect'));
    }

    public function store(Menu $menu, CreateMenuItemRequest $request)
    {
        $this->menuItem->create($this->addMenuId($menu, $request));

        return redirect()->route('admin.menu.menu.edit', [$menu->id])
            ->withSuccess(trans('menu::messages.menuitem created'));
    }

    public function edit(Menu $menu, Menuitem $menuItem)
    {
        $pages = $this->page->all();

        $menuSelect = $this->getMenuSelect($menu);

        return view('menu::admin.menuitems.edit', compact('menu', 'menuItem', 'pages', 'menuSelect'));
    }

    public function update(Menu $menu, Menuitem $menuItem, UpdateMenuItemRequest $request)
    {
        $this->menuItem->update($menuItem, $this->addMenuId($menu, $request));

        return redirect()->route('admin.menu.menu.edit', [$menu->id])
            ->withSuccess(trans('menu::messages.menuitem updated'));
    }

    public function destroy(Menu $menu, Menuitem $menuItem)
    {
        $this->menuItem->destroy($menuItem);

        return redirect()->route('admin.menu.menu.edit', [$menu->id])
            ->withSuccess(trans('menu::messages.menuitem deleted'));
    }

    /**
     * @param Menu, $menuItemId
     * @return array
     */
    private function getMenuSelect($menu)
    {
        return $menu->menuitems()->where('is_root', '!=', true)->get()->nest()->listsFlattened('title');
    }

    /**
     * @param  Menu $menu
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addMenuId(Menu $menu, FormRequest $request)
    {
        $data = $request->all();

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $lang) {
            if ($data['link_type'] === 'page' && ! empty($data['page_id'])) {
                $data[$lang]['uri'] = $this->getUri($data['page_id'], $lang);
            }
        }

        if (empty($data['parent_id'])) {
            $data['parent_id'] = $this->menuItem->getRootForMenu($menu->id)->id;
        }

        return array_merge($data, ['menu_id' => $menu->id]);
    }

    /**
     * Get uri
     * @param $pageId
     * @param $lang
     * @return string
     */
    private function getUri($pageId, $lang)
    {
        $linkPathArray = array();

        array_push($linkPathArray, $this->getPageSlug($pageId, $lang));

        $currentItem = $this->menuItem->getByAttributes(['page_id' => $pageId])->first();

        if (! is_null($currentItem)) {
            $hasParentItem = !(is_null($currentItem->parent_id)) ? true : false;

            while ($hasParentItem) {
                $parentItemId = isset($parentItem) ? $parentItem->parent_id : $currentItem->parent_id;

                $parentItem = $this->menuItem->find($parentItemId);

                if ($parentItem->is_root != true) {
                    if (!empty($parentItem->page_id)) {
                        array_push($linkPathArray, $this->getPageSlug($parentItem->page_id, $lang));
                    } else {
                        array_push($linkPathArray, $this->getParentUri($parentItem, $linkPathArray));
                    }
                }

                $hasParentItem = !is_null($parentItem->parent_id) ? true : false;
            }
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
    private function getPageSlug($id, $lang)
    {
        $page = $this->page->find($id);
        $translation = $page->translate($lang);

        if ($translation === null) {
            return $page->translate(config('app.fallback_locale'))->slug;
        }

        return $translation->slug;
    }

    /**
     * Get parent uri
     *
     * @params $pageId, $lang
     * @return string
     */
    private function getParentUri($item, $linkPathArray)
    {
        return ! is_null($item->uri) ? $item->uri . '/' . implode('/', $linkPathArray) : implode('/', $linkPathArray);
    }
}
