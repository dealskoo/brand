<?php

namespace Dealskoo\Brand\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Brand\Tests\TestCase;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'brand::brand.brands'));
        $this->assertNotNull(SellerMenu::findBy('title', 'brand::brand.brands'));
    }
}
