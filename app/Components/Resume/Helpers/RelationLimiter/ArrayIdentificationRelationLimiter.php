<?php

namespace App\Components\Resume\Helpers\RelationLimiter;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

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

    public function isLimitReached(): bool
    {
        $current = $this->resume->getRelation($this->relation)->pluck('id')->sort()->count();
        if ($current + count($this->value) > $this->limit) {
            $this->errorMessage = Lang::get(
                sprintf('validation.resume.%s.limit_reached', Str::snake($this->relation)),
                ['limit' => $this->limit],
            );

            return false;
        }

        return true;
    }
}
