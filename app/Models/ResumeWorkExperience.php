<?php

namespace App\Models;

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
}
