<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['superadmin', 'classique', 'premium', 'entreprise']),
            'description' => $this->faker->sentence,
        ];
    }
}
