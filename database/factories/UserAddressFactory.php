<?php

namespace Database\Factories;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'zip' => $this->faker->word,
        'state' => $this->faker->word,
        'city' => $this->faker->word,
        'district' => $this->faker->word,
        'address' => $this->faker->word,
        'number' => $this->faker->word,
        'complement' => $this->faker->text,
        'is_default' => $this->faker->word,
        'use_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
