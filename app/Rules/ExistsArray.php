<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ExistsArray implements ValidationRule
{
    public function __construct(
        protected Builder $builder,
        protected string  $column
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->builder->whereIn($this->column, $value)->exists()) {
            $fail('Invalid ' . $attribute);
        }
    }
}
