<?php

namespace App\Components\City\Repositories;

use App\Models\City;

class CityRepository
{
    public function all(): array
    {
        return City::query()->get()->toArray();
    }
}
