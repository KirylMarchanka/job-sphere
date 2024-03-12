<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class JobApply extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['resume_id', 'employer_job_id', 'type', 'status'];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(EmployerJob::class);
    }

    public function employerJob(): BelongsTo
    {
        return $this->belongsTo(EmployerJob::class);
    }

    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }
}
