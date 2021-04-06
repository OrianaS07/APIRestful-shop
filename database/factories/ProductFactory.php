<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'quantity' => $this->faker->numberBetween(1,10),
            'status' => $this->faker->randomElement([Product::PRODUCTO_NO_DISPONIBLE, Product::PRODUCTO_DISPONIBLE]),
            'image' => $this->faker->randomElement(['1.jpg','2.jpg','3.jpg']),
            'user_id' => User::all()->random()->id
        ];
    }
}
