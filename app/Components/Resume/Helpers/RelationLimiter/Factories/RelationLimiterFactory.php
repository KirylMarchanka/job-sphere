<?php

namespace App\Components\Resume\Helpers\RelationLimiter\Factories;

use App\Components\Resume\Helpers\RelationLimiter\ArrayIdentificationRelationLimiter;
use App\Components\Resume\Helpers\RelationLimiter\BaseRelationLimiter;
use App\Components\Resume\Helpers\RelationLimiter\CommonRelationLimiter;
use App\Components\Resume\Helpers\RelationLimiter\Interfaces\RelationLimiter;
use InvalidArgumentException;

class RelationLimiterFactory
{
    /**
     * @param string $relation
     * @return BaseRelationLimiter
     */
    public static function init(string $relation): RelationLimiter
    {
        return (match ($relation) {
            'specializations', 'skills' => new CommonRelationLimiter(),
            'education', 'workExperience' => new ArrayIdentificationRelationLimiter(),
            default => throw new InvalidArgumentException(sprintf('relation [%s] is not supported yet', $relation)),
        })->setRelation($relation);
    }
}
