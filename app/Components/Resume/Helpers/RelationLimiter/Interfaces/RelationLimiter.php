<?php

namespace App\Components\Resume\Helpers\RelationLimiter\Interfaces;

interface RelationLimiter
{
    public function isLimitReached(): bool;
}
