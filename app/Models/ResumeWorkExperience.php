<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeWorkExperience extends Model
{
    use HasFactory;

    protected $fillable = ['resume_id', 'company_name', 'city_id', 'position', 'site_url', 'description', 'from', 'to'];

    protected $casts = [
        'from' => 'date:Y-m',
        'to' => 'date:Y-m',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    protected function from(): Attribute
    {
        return Attribute::make(set: fn(string $value) => Carbon::parse($value)->setDay(1));
    }

    protected function to(): Attribute
    {
        return Attribute::make(set: fn(?string $value) => $value ? Carbon::parse($value)->setDay(1) : null);
    }
}
