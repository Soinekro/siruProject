<?php

namespace Database\Factories;

use App\Models\Distrit;
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
            'district_id'  => Distrit::all()->random()->id,
            'ruc' => $this->faker->unique()->numerify('###########'),
            'address' => $this->faker->address,
            'social_reason'=> $this->faker->unique()->word,
            'user_sol' => $this->faker->userName(),
            'password_sol' => $this->faker->password(),
            'certificate' => $this->faker->url(),
            //'certificate_password' => Hash::make('password'),
            'logo'=> $this->faker->url(),
        ];
    }
}
