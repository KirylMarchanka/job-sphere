<?php

namespace Database\Factories;

use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Models\User;
use Database\Factories\Traits\GetEnumValueTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resume>
 */
class ResumeFactory extends Factory
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
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle(),
            'status' => $this->getEnumValue(StatusEnum::cases()),
            'salary' => $this->faker->boolean() ? $this->faker->numberBetween(100, 10000) : null,
            'employment' => $this->getEnumValue(EmploymentEnum::cases()),
            'schedule' => $this->getEnumValue(ScheduleEnum::cases()),
            'description' => $this->faker->text(),
        ];
    }
}
