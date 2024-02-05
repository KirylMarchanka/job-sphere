<?php

namespace App\Models;

use App\Components\Resume\Contacts\Helpers\ResumeContactParser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeContact extends Model
{
    use HasFactory;

    protected function preferredContactSource(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => match ($value) {
                1 => 'email',
                2 => 'linkedin',
                3 => 'telegram',
                default => 'mobile_number',
            }
        );
    }

    protected function otherSources(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => ResumeContactParser::parse(json_decode($value, true)),
        );
    }
}
