<?php

namespace App\Components\Employer\Sector\Repositories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Builder;

class SectorRepository
{
    public function all(array $select = ['*']): array
    {
        return Sector::query()
            ->select($select)
            ->orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END") // Order parents before children
            ->orderBy('parent_id')
            ->orderBy('id')
            ->with('parent')
            ->get()
            ->toArray();
    }
}
