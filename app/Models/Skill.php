<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function resumes(): BelongsToMany
    {
        return $this->belongsToMany(Resume::class);
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(EmployerJob::class);
    }
}
