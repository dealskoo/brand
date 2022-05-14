<?php

namespace Dealskoo\Brand\Tests\Unit;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Brand\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_logo_url()
    {
        $file = '1.png';
        $brand = Brand::factory()->create(['logo' => $file]);
        $this->assertEquals(Storage::url($file), $brand->logo_url);
    }

    public function test_slug()
    {
        $slug = 'Baa';
        $brand = Brand::factory()->create(['slug' => $slug]);
        $this->assertNotNull($brand->slug);
        $this->assertEquals(Str::lower($slug), $brand->slug);
    }

    public function test_country()
    {
        $brand = Brand::factory()->create();
        $this->assertNotNull($brand->country);
    }

    public function test_seller()
    {
        $brand = Brand::factory()->create();
        $this->assertNotNull($brand->seller);
    }

    public function test_approved()
    {
        $count = 2;
        Brand::factory()->create();
        Brand::factory()->count($count)->approved()->create();
        $this->assertEquals($count, Brand::approved()->count());
    }
}
