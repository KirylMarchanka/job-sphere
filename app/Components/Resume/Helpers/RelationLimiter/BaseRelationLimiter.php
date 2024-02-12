<?php

namespace App\Components\Resume\Helpers\RelationLimiter;

use App\Components\Resume\Helpers\RelationLimiter\Interfaces\RelationLimiter;
use App\Models\Resume;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

abstract class BaseRelationLimiter implements RelationLimiter
{
    protected Resume $resume;
    protected ?string $errorMessage = null;
    protected int $limit;
    protected string $relation;
    protected array $value;

    public function setResume(Resume $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function setLimit(int $limit): BaseRelationLimiter
    {
        $this->limit = $limit;
        return $this;
    }

    public function setRelation(string $relation): BaseRelationLimiter
    {
        $this->relation = $relation;
        return $this;
    }

    public function setValue(array $value): BaseRelationLimiter
    {
        $this->value = $value;
        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function isLimitReached(): bool
    {
        $current = $this->resume->getRelation($this->relation)->pluck('id')->sort()->toArray();
        $attached = array_diff($this->value, $current);
        $detached = array_diff($current, $this->value);

        if (!(count($current) - count($detached)) + count($attached) <= $this->limit) {
            $this->errorMessage = Lang::get(
                sprintf('validation.resume.%s.limit_reached', Str::slug($this->relation)),
                ['limit' => $this->limit],
            );

            return false;
        }

        return true;
    }
}
