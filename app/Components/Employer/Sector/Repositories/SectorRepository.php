<?php

namespace App\Components\Employer\Sector\Repositories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Builder;

class SectorRepository
{
    public function all(?int $parentId, array $select = ['*']): array
    {
        return Sector::query()->select($select)->when(
            $parentId,
            fn(Builder $builder) => $builder->where('parent_id', $parentId),
            fn(Builder $builder) => $builder->whereNull('parent_id')
        )->with('parent')->get()->toArray();
    }
}
