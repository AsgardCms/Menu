<?php namespace Modules\Menu\Tests;

class EloquentMenuItemRepositoryTest extends BaseMenuTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * New menu item should be created
     * @test
     */
    public function it_should_create_menu_item_as_root()
    {
        $menu = $this->createMenu('second', 'Second Menu');

        $data = [
            'menu_id' => $menu->id,
            'position' => 0,
            'target' => '_self',
            'module_name' => 'blog',
            'en' => [
                'status' => 1,
                'title' => 'First Menu Item',
                'uri' => 'item1',
            ],
            'fr' => [
                'status' => 1,
                'title' => 'Premier item de menu',
                'uri' => 'item1',
            ],
        ];

        $menuItem = $this->menuItem->create($data);

        $this->assertEquals(null, $menuItem->parent_id);
    }
}
