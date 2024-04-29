<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->name();
        $slug = Str::slug($name);
        $subcat_id = [2,9,12,13,14];
        $subcatRand = array_rand($subcat_id);
        $cat_id = [1,10,11];
        $cat_idRand = array_rand($cat_id);
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reiciendis itaque tenetur natus id, repellendus ducimus magni amet impedit aut nisi error, quisquam atque, est cum eaque? Officia nostrum dolorem dolor.",
            'short_description' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reiciendis itaque tenetur natus id, repellendus ducimus magni amet impedit aut nisi error, quisquam atque, est cum eaque? Officia nostrum dolorem dolor.",
            'shipping_returns' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reiciendis itaque tenetur natus id, repellendus ducimus magni amet impedit aut nisi error, quisquam atque, est cum eaque? Officia nostrum dolorem dolor.",
            'price' => rand(100,1000),
            'subcat_id' => $subcat_id[$subcatRand],
            'cat_id' => $cat_id[$cat_idRand],
            'status' => rand(0,1),
            'is_featured' => rand(0,1),
            'sku' => "#Quang".rand(3,30),
            'track_qty' => rand(1,100)
            
        ];
    }
}
