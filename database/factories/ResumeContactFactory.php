<?php

namespace Database\Factories;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Models\Resume;
use Database\Factories\Traits\GetEnumValueTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeContact>
 */
class ResumeContactFactory extends Factory
{
    use GetEnumValueTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'mobile_number' => sprintf('375%d%d', $this->faker->randomElement([25, 29, 33, 44]), $this->faker->randomNumber(7, true)),
            'comment' => $this->faker->words(asText: true),
            'email' => $this->faker->unique()->safeEmail(),
            'preferred_contact_source' => $this->getEnumValue(ResumeContactPreferredContactEnum::cases()),
            'other_sources' => [
                'linkedin' => $this->faker->firstName() . '-' . $this->faker->lastName(),
                'telegram' => $this->faker->word(),
            ],
        ];
    }
}
