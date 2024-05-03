<?php

namespace App\Rules;

use App\Enums\NodeType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class MustBeNull implements ValidationRule
{
    public function __construct(private ?string $fieldType, private NodeType $type)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->fieldType !== $this->type->value && !empty($value)) {
            $fail("A :attribute must be null when type is {$this->fieldType}.");
        }
    }
}
