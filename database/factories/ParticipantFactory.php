<?php

namespace Database\Factories;

use App\Models\Dialect;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail(),
            'theme_app' => $this->faker->randomElement(['D' , 'L']),
            'lang_app' => Language::get()->random()->id,
            'dialect_id' => Dialect::get()->random()->id,
        ];
    } 
}
