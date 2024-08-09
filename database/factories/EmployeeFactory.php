<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 60),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'address' => $this->faker->address(),
            'position' => $this->faker->randomElement(['Manager', 'Developer', 'Designer']),
            'department' => $this->faker->randomElement(['HR', 'IT', 'Finance']),
            'salary' => $this->faker->numberBetween(50000, 150000),
        ];
    }
}
