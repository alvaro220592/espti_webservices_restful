<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $todos_ids_categorias = Category::pluck('id')->all();
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'category_id' => $todos_ids_categorias[array_rand($todos_ids_categorias, 2)[0]] // Pegando id randomico das categorias
        ];
    }
}
