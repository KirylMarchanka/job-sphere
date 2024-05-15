<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumePersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'middle_name', 'birthdate', 'sex', 'city_id'];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
