<?php

namespace Database\Factories;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    public function definition()
    {
        return [
            'enterprise_id'=>Enterprise::all()->unique()->random()->id,
            'role' => $this->faker->randomElement([User::SUPER_ADMIN, User::ADMIN,User::USER]),
            'dni' => $this->faker->unique()->numerify('########'),
            'name' => $this->faker->name(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password'=> Hash::make('12345678'),
            'status' => $this->faker->randomElement([User::ACTIVO, User::INACTIVO]),
            'pass_status' => $this->faker->randomElement([true,false]),
            'email_verified' => $this->faker->randomElement([1,0]),
            //'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
