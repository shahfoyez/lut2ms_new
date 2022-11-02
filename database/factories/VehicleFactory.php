<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'codename' => 'Bus '.$this->faker->numberBetween($min=1000, $max=2000),
            'license' => $this->faker->bothify($string = '###??###'),
            'capacity' => $this->faker->numberBetween($min=45, $max=60),
            'meter_start' => $this->faker->numberBetween($min=1000, $max=1200),
            'type' => 1,
            'status' => 'available'
        ];
    }
}
