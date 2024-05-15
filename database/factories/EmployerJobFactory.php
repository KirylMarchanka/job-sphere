<?php

namespace Database\Factories;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Models\City;
use App\Models\Employer;
use Database\Factories\Traits\GetEnumValueTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployerJob>
 */
class EmployerJobFactory extends Factory
{
    use GetEnumValueTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $withSalary = $this->faker->boolean();
        $salary = $this->faker->numberBetween(500,1999);

        return [
            'employer_id' => Employer::factory(),
            'title' => $this->faker->jobTitle(),
            'salary_from' => $withSalary ? $salary : null,
            'salary_to' => $withSalary ? $salary + $this->faker->numberBetween(100,5000) : null,
            'salary_employer_paid_taxes' => $this->faker->boolean(),
            'experience' => $this->getEnumValue(JobExperienceEnum::cases()),
            'education' => $this->getEnumValue(JobEducationEnum::cases()),
            'schedule' => $this->getEnumValue(ScheduleEnum::cases()),
            'description' => $this->faker->realText(),
            'city_id' => City::factory(),
            'street' => $this->faker->streetName(),
            'employment' => $this->getEnumValue(EmploymentEnum::cases()),
            'is_archived' => false,
        ];
    }
}
