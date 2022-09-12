<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enterprise>
 */
class EnterpriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ruc' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->company,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'user_id'  => \App\Models\User::all()->unique()->random()->id,
            'user_sol' => $this->faker->userName,
            'password_sol' => $this->faker->password,
        ];
    }
}
