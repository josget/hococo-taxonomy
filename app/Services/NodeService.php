<?php

namespace App\Services;

use App\Enums\NodeType;
use App\Models\Node;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NodeService
{
    public function addNode(
        string $name,
        ?int $parentId,
        NodeType $type,
        ?string $zipCode,
        ?float $monthlyRent,
    ): Node
    {
        DB::beginTransaction();

        $node = Node::create([
            'name' => $name,
            'parent_id' => $parentId,
            'type' => $type
        ]);

        $node->attribute()->updateOrCreate([
            'zip_code' => $zipCode,
            'monthly_rent' => $monthlyRent,
        ]);

        $this->updateHeight($node);

        DB::commit();

        return $node->fresh();
    }

    public function getNodesWithFirstLayerChildren(?int $height, ?NodeType $type): Collection
    {
        return Node::with(['children', 'attribute'])
            ->when(!is_null($height), fn ($q) => $q->where('height', $height))
            ->when(!is_null($type), fn ($q) => $q->where('type', $type))
            ->get();
    }

    public function getNode(int $nodeId): Node
    {
        return Node::with(['children', 'attribute'])->whereId($nodeId)->first();
    }

    public function changeParentNode(Node $node, ?int $parentId): Node
    {
        $node->update(['parent_id' => $parentId]);

        return $node;
    }

    public function updateHeight(Node $node): Node
    {
        $parentNodeHeight = $node->parent_id ? $node->parent->height + 1 : 0;

        $node->update(['height' => $parentNodeHeight]);

        foreach ($node->children as $child) {
            $this->updateHeight($child);
        }

        return $node;
    }
}