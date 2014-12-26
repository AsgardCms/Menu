<?php namespace Modules\Menu\Tests;

class MenuOrdenerTest extends BaseMenuTest
{
    public function setUp()
    {
        parent::setUp();

        $data = [
            'name' => 'main',
            'primary' => true,
            'en' => [
                'title' => 'Test Menu',
                'status' => 1,
            ]
        ];
        $this->menu->create($data);
    }
}
