<?php

namespace Database\Factories;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
    protected $model = Enterprise::class;
    public function definition()
    {
        return [
            'distrit_id'  => rand(1,1000),
            'ruc' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'phone' => $this->faker->numerify('##########'),
            'social_reason'=> $this->faker->unique()->word,
            'user_sol' => $this->faker->userName(),
            'password_sol' => $this->faker->password(),
            'certificate' => $this->faker->url(),
            'certificate_password' => Hash::make('password'),
            'logo'=> $this->faker->url(),
        ];
    }
}
