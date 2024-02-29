<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name'];

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'parent_id', 'id')->select(['id', 'name', 'slug']);
    }
}
