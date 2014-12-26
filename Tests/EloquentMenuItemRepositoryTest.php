<?php namespace Modules\Menu\Tests;

class EloquentMenuItemRepositoryTest extends BaseMenuTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * New menu item should be created as child of main root item
     * @test
     */
    public function it_should_create_menu_item_under_correct_root_item()
    {
        $data = [
            'menu_id' => 1,
            'position' => 0,
            'target' => '_self',
            'module_name' => 'blog',
            'en' => [
                'status' => 1,
                'title' => 'First Menu Item',
                'uri' => 'item1'
            ],
            'fr' => [
                'status' => 1,
                'title' => 'Premier item de menu',
                'uri' => 'item1'
            ],
        ];

        $menuItem = $this->menuItem->create($data);

        $this->assertEquals(1, $menuItem->parent_id);
    }
}
