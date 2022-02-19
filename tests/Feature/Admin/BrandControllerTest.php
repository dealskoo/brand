<?php

namespace Dealskoo\Brand\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Brand\Models\Brand;
use Dealskoo\Brand\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.brands.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.brands.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.brands.show', $brand));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.brands.edit', $brand));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $brand = Brand::factory()->create();
        $brand1 = Brand::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.brands.update', $brand), $brand1->only([
            'approved',
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $admin = Admin::factory()->isOwner()->create();
        $brand = Brand::factory()->create();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.brands.destroy', $brand));
        $response->assertStatus(200);
        $this->assertSoftDeleted($brand);
    }
}
