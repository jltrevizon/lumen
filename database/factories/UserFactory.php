<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => Role::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'name' => $this->faker->name,
            'surname' => $this->faker->name,
            'password' => app('hash')->make('123456'),
            'email' => $this->faker->unique()->safeEmail,
            'avatar' => $this->faker->imageUrl,
            'phone' => $this->faker->numerify('#########'),
            'first_login' => $this->faker->boolean(true),
            'active' => $this->faker->boolean(true)
        ];
    }
}
