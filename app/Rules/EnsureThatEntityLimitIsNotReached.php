<?php

namespace App\Rules;

use App\Components\Resume\Helpers\RelationLimiter\Factories\RelationLimiterFactory;
use App\Models\Resume;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class EnsureThatEntityLimitIsNotReached implements ValidationRule
{
    public function __construct(private readonly Resume $resume)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $relation = Str::camel($attribute);
        $limiter = RelationLimiterFactory::init($relation)
            ->setValue($value)
            ->setResume($this->resume->loadMissing($relation))
            ->setLimit($this->getLimit($attribute));

        if ($limiter->isLimitReached()) {
            return;
        }

        $fail($limiter->getErrorMessage());
    }

    private function getLimit(string $attribute): int
    {
        return match ($attribute) {
            'skills' => 25,
            'work_experience' => 10,
            default => 5
        };
    }
}
