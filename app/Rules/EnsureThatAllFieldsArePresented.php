<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureThatAllFieldsArePresented implements ValidationRule
{
    /**
     * @param array<string> $fields
     */
    public function __construct(private readonly array $fields)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (array_key_exists('id', $value)) {
            return;
        }

        $missing = [];
        foreach ($this->fields as $field) {
            if (!array_key_exists($field, $value)) {
                $missing[] = $field;
            }
        }

        if (empty($missing)) {
            return;
        }

        $fail('validation.resume.missing_field')->translate(['fields' => implode(',', $missing)]);
    }
}
