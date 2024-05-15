<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $appends = ['city_with_country'];

    public $timestamps = false;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cityWithCountry(): Attribute
    {
        return Attribute::make(get: fn() => sprintf(
            '%s, %s',
            $this->getAttribute('name'),
            $this->loadMissing('country')->getRelation('country')->getAttribute('name')
        ));
    }
}
