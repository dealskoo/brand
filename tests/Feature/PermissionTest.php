<?php

namespace Dealskoo\Brand\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Brand\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('brands.index'));
        $this->assertNotNull(PermissionManager::getPermission('brands.show'));
        $this->assertNotNull(PermissionManager::getPermission('brands.edit'));
        $this->assertNotNull(PermissionManager::getPermission('brands.destroy'));
    }
}
