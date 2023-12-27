<?php

namespace App\Components\Resume\Specialization\Repositories;

use App\Models\Specialization;

class SpecializationRepository
{
    public function all(array $select = ['*']): array
    {
        $specializations = Specialization::query()->select($select)->orderBy('name')->get();

        return $specializations->whereNull('parent_id')->map(function (Specialization $specialization) use ($specializations) {
            $childSpecializations = $specializations->where('parent_id', $specialization->getAttribute('id'));
            if ($childSpecializations->isEmpty()) {
                return null;
            }

            $childSpecializations = $childSpecializations
                ->map(fn(Specialization $specialization) => $specialization->only(['id', 'name']))
                ->values()
                ->toArray();

            return [$specialization->getAttribute('name') => $childSpecializations];
        })->filter()->values()->toArray();
    }
}
