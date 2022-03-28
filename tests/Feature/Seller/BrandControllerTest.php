<?php

namespace Dealskoo\Brand\Tests\Feature\Seller;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Brand\Tests\TestCase;
use Dealskoo\Seller\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.brands.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.brands.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.brands.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        Storage::fake();
        $seller = Seller::factory()->create();
        $brand = Brand::factory()->make(['seller_id' => $seller->id, 'country_id' => $seller->country->id]);
        $response = $this->actingAs($seller, 'seller')->post(route('seller.brands.store'), [
            'logo' => UploadedFile::fake()->image('file.jpg'),
            'name' => $brand->name,
            'website' => $brand->website,
            'description' => $brand->description
        ]);
        $response->assertStatus(302);
        $brand = Brand::query()->first();
        Storage::assertExists('brands/' . $brand->id . '.jpg');
    }

    public function test_edit()
    {
        $seller = Seller::factory()->create();
        $brand = Brand::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.brands.edit', $brand));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $seller = Seller::factory()->create();
        $brand = Brand::factory()->create(['seller_id' => $seller->id, 'country_id' => $seller->country->id]);
        $brand1 = Brand::factory()->make();
        $response = $this->actingAs($seller, 'seller')->put(route('seller.brands.update', $brand), [
            'name' => $brand1->name,
            'website' => $brand1->website,
            'description' => $brand1->description
        ]);
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $seller = Seller::factory()->create();
        $brand = Brand::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->delete(route('seller.brands.destroy', $brand));
        $response->assertStatus(200);
    }
}
