<?php

namespace App\Components\Resume\DTOs;

use App\Components\Resume\Personal\Enums\SexEnum;
use Carbon\Carbon;

class ResumePersonalInformationDto
{
    public string $name;
    public string $surname;
    public ?string $middleName;
    public Carbon $birthdate;
    public SexEnum $sex;
    public int $cityId;

    public function __construct(
        string  $name,
        string  $surname,
        ?string $middleName,
        Carbon  $birthdate,
        SexEnum $sex,
        int     $cityId
    )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->middleName = $middleName;
        $this->birthdate = $birthdate;
        $this->sex = $sex;
        $this->cityId = $cityId;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'middle_name' => $this->middleName,
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'sex' => $this->sex->value,
            'city_id' => $this->cityId,
        ];
    }
}
