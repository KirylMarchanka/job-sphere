<?php

namespace App\Components\Resume\Helpers\RelationLimiter;

class ArrayIdentificationRelationLimiter extends BaseRelationLimiter
{
    public function setValue(array $value): BaseRelationLimiter
    {
        $value = array_map(
            fn(array $value) => $value['id'],
            array_filter($value, fn(array $relation) => isset($relation['id']))
        );

        return parent::setValue($value);
    }
}
