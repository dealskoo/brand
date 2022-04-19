<?php

namespace Database\Factories\Dealskoo\Brand\Models;

use Dealskoo\Brand\Models\Brand;
use Dealskoo\Seller\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $seller = Seller::factory()->create();

        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->name,
            'website' => $this->faker->url,
            'logo' => $this->faker->imageUrl,
            'score' => $this->faker->numberBetween(0, 5),
            'description' => $this->faker->text,
            'country_id' => $seller->country_id,
            'seller_id' => $seller->id,
            'approved' => $this->faker->boolean
        ];
    }
}
