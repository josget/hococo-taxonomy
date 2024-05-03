<?php

namespace App\Http\Requests\Node;

use App\Rules\ValidParentNodeByType;
use Illuminate\Foundation\Http\FormRequest;

class ChangeParentNodeRequest extends FormRequest
{
    public function rules(): array
    {
        $node = $this->route('node');

        return [
            'parent_id' => [
                'nullable',
                'exists:nodes,id',
                new ValidParentNodeByType($node?->type->value),
                function ($attribute, $value, $fail) use ($node) {
                    if ($value == $node->id) {
                        $fail('The parent node cannot be the node itself.');
                    }
                },
            ],
        ];
    }
}
