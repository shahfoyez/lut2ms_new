<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Routex>
 */
class RoutexFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user = User::get()->first();
        return [
            'route' =>  $this->faker->randomNumber(3, true),
            'slabel' => $this->faker->city(),
            'slat' => $this->faker->latitude(-90, 90),
            'slon' => $this->faker->latitude(-90, 90),
            'added_by' => $user->id
        ];

    }
}
