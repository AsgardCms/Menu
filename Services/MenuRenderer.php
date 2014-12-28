<?php namespace Modules\Menu\Services;

use Illuminate\Support\Facades\URL;
use Illuminate\Html\FormFacade as Form;

class MenuRenderer
{
    /**
     * @var int Id of the menu to render
     */
    protected $menuId;
    /**
     * @var string
     */
    private $startTag = '<div class="dd">';
    /**
     * @var string
     */
    private $endTag = '</div>';
    /**
     * @var string
     */
    private $menu = '';

    /**
     * @param $menuId
     * @param $menuItems
     * @return string
     */
    public function renderForMenu($menuId, $menuItems)
    {
        $this->menuId = $menuId;

        $this->menu .= $this->startTag;
        $this->generateHtmlFor($menuItems);
        $this->menu .= $this->endTag;

        return $this->menu;
    }

    /**
     * Generate the html for the given items
     * @param $items
     */
    private function generateHtmlFor($items)
    {
        $this->menu .= '<ol class="dd-list">';
        foreach ($items as $item) {
            $this->menu .= "<li class=\"dd-item\" data-id=\"{$item->id}\">";
            $editLink = URL::route('dashboard.menuitem.edit', [$this->menuId, $item->id]);
            $removeLink = URL::route('dashboard.menuitem.destroy', [$this->menuId, $item->id]);
            $removeFormOpenTag = Form::open(['url' => $removeLink, 'method' => 'delete']);
            $this->menu .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: inline">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    {$removeFormOpenTag}
        <button type="submit" class="btn btn-sm btn-danger" style="float:left; margin-right: 15px;">
           <i class="fa fa-times"></i>
        </button>
    </form>
</div>
HTML;
            $this->menu .= "<div class=\"dd-handle\">{$item->title}</div>";

            if ($this->hasChildren($item)) {
                $this->generateHtmlFor($item->children);
            }

            $this->menu .= '</li>';
        }
        $this->menu .= '</ol>';
    }

    /**
     * @param $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return !is_array($item->children);
    }
}
