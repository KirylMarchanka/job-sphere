<?php

namespace Database\Factories;

use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Models\EducationalInstitution;
use App\Models\Resume;
use Database\Factories\Traits\GetEnumValueTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeEducation>
 */
class ResumeEducationFactory extends Factory
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
            'educational_institution_id' => EducationalInstitution::factory(),
            'department' => $this->faker->word(),
            'specialization' => $this->faker->word(),
            'degree' => $this->getEnumValue(DegreeEnum::cases()),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
