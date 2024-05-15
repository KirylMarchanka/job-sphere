<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeWorkExperience>
 */
class ResumeWorkExperienceFactory extends Factory
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
            'company_name' => $this->faker->company(),
            'city_id' => City::factory(),
            'position' => $this->faker->jobTitle(),
            'site_url' => $this->faker->url(),
            'description' => $this->faker->text(),
            'from' => $this->faker->date(max: '-1 month'),
            'to' => $this->faker->date(),
        ];
    }
}
