<?php namespace Modules\Menu\Tests;

class MenuOrdenerTest extends BaseMenuTest
{
    /**
     * @var \Modules\Menu\Services\MenuOrdener
     */
    protected $menuOrdener;

    public function setUp()
    {
        parent::setUp();
        $this->createMenu('main', 'Main Menu');
        $this->menuOrdener = app('Modules\Menu\Services\MenuOrdener');
    }

    /** @test */
    public function it_makes_item_child_of()
    {
        // Prepare
        $menu = $this->createMenu('main', 'Main Menu');
        $menuItem1 = $this->createMenuItemForMenu($menu->id, 0);
        $menuItem2 = $this->createMenuItemForMenu($menu->id, 0);
        $request = [
            0 => [
                'id' => $menuItem1->id,
                'children' => [
                    0 => [
                        'id' => $menuItem2->id
                    ]
                ]
            ]
        ];

        // Run
        $this->menuOrdener->handle($request);

        // Assert
        $child = $this->menuItem->find($menuItem2->id);
        $this->assertEquals($menuItem1->id, $child->parent_id);
    }
}
