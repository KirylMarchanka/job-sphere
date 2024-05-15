<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumePersonalInformation>
 */
class ResumePersonalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(),
            'birthdate' => $this->faker->date(),
            'sex' => $this->faker->randomElement(['m', 'f']),
            'city_id' => City::factory(),
        ];
    }
}
