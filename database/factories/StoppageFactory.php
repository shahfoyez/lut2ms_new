<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Routex;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stoppage>
 */
class StoppageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $route = Routex::get()->first();
        $user = User::get()->first();
        return [
            'route' => $route->id,
            'slabel' => $this->faker->city(),
            'slat' => $this->faker->latitude(-90, 90),
            'slon' => $this->faker->latitude(-90, 90),
            'added_by' => $user->id
        ];
    }
}
