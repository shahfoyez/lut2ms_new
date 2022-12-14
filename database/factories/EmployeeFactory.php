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
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'idNumber' => $this->faker->numerify('##########'),
            'phone' => $this->faker->numerify('013-########'),
            'designation' => 1,
            'department' => 1,
            'added_by' => 1,
            'status' => 0
        ];
    }
}
