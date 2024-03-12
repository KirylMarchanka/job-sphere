<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class JobApply extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['resume_id', 'employer_job_id', 'type', 'status'];

    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }
}
