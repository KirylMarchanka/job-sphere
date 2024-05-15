<?php

namespace Database\Factories\Traits;

trait GetEnumValueTrait
{
    private function getEnumValue(array $cases): string|array|int
    {
        return array_rand(array_column($cases, 'value'));
    }
}
