<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['job_apply_id', 'title', 'channel'];

    public function messages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function jobApply(): BelongsTo
    {
        return $this->belongsTo(JobApply::class);
    }
}
