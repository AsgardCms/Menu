<?php namespace Modules\Menu\Tests;

class MenuOrdenerTest extends BaseMenuTest
{
    public function setUp()
    {
        parent::setUp();
        $this->createMenu('main', 'Main Menu');
    }

    /** @test */
    public function it_ok()
    {
        $this->assertTrue(true);
    }
}
