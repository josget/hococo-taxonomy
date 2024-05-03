<?php

namespace App\Http\Resources\Node;

use App\Models\NodeAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property NodeAttribute $resource
 */
class NodeAttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'monthlyRent' => $this->resource->monthly_rent,
            'zipCode' => $this->resource->zip_code,
        ];
    }
}
