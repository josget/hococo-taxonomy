<?php

namespace App\Rules;

use App\Enums\NodeType;
use App\Models\Node;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class ValidParentNodeByType implements ValidationRule
{
    public function __construct(private ?string $type)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        $parentNode = Node::find($value);

        if ($parentNode && $this->type === NodeType::BUILDING->value && $parentNode->type === NodeType::PROPERTY) {
            $fail('A Building node cannot have a Property node as parent.');
        }
    }
}
