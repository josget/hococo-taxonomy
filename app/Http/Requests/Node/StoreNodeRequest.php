<?php

namespace App\Http\Requests\Node;

use App\Enums\NodeType;
use App\Rules\MustBeNull;
use App\Rules\ValidParentNodeByType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNodeRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            /**
             * @example root
             */
            'name' => [
                'required',
                'unique:nodes'
            ],
            'type' => [
                'required',
                Rule::enum(NodeType::class),
            ],
            /**
             * @example null
             */
            'parent_id' => [
                'nullable',
                'exists:nodes,id',
                new ValidParentNodeByType($this->type),
            ],
            /**
             * @example null
             */
            'zip_code' => [
                'nullable',
                'required_if:type,'.NodeType::BUILDING->value,
                new MustBeNull($this->type, NodeType::BUILDING),

            ],
            /**
             * @example null
             */
            'monthly_rent' => [
                'nullable',
                'required_if:type,'.NodeType::PROPERTY->value,
                new MustBeNull($this->type, NodeType::PROPERTY),
                'numeric'
            ]
        ];
    }
}
