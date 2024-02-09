<?php

namespace App\Components\Resume\Specialization\Repositories;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Builder;

class SpecializationRepository
{
    public function all(array $select = ['*']): array
    {
        $specializations = $this->baseQuery($select)->orderBy('name')->get();

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

    public function getIds(): array
    {
        return $this->baseQuery(['id'])
            ->whereNotNull('parent_id')
            ->get()
            ->pluck('id')
            ->toArray();
    }

    private function baseQuery(array $select): Builder
    {
        return Specialization::query()->select($select);
    }
}
