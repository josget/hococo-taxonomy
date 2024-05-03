<?php

namespace App\Http\Resources\Node;

use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Node $resource
 */
class NodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'height' => $this->resource->height,
            'parentId' => $this->resource->parent_id,
            'children' => self::collection($this->whenLoaded('children')),
            'attribute' => NodeAttributeResource::make($this->resource->attribute),
        ];
    }
}
