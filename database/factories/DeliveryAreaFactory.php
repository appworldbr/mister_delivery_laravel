<?php

namespace Database\Factories;

use App\Models\DeliveryArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryAreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryArea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'initial_zip' => $this->faker->word,
        'final_zip' => $this->faker->word,
        'price' => $this->faker->word,
        'prevent' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
