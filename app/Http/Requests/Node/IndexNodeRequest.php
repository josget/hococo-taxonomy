<?php

namespace App\Http\Requests\Node;

use App\Enums\NodeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexNodeRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            /**
             * @example null
             */
            'height' => [
                'nullable',
                'numeric'
            ],
            /**
             * @example null
             */
            'type' => [
                'nullable',
                Rule::enum(NodeType::class),
            ],
        ];
    }
}
