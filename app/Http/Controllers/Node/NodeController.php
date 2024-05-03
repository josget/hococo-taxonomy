<?php

namespace App\Http\Controllers\Node;

use App\Enums\NodeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Node\IndexNodeRequest;
use App\Http\Requests\Node\StoreNodeRequest;
use App\Http\Resources\Node\NodeResource;
use App\Models\Node;
use App\Services\NodeService;
use Illuminate\Http\JsonResponse;

class NodeController extends Controller
{
    public function __construct(readonly private NodeService $nodeService)
    {
    }

    /**
     * @operationId Get list of nodes
     */
    public function index(IndexNodeRequest $request): JsonResponse
    {
        $type = $request->input('type')
            ? NodeType::from($request->input('type'))
            : null;

        $nodes = $this->nodeService->getNodesWithFirstLayerChildren(
            request()->input('height'),
            $type,
        );

        return response()->json(NodeResource::collection($nodes));
    }

    /**
     * @operationId Add a node
     *
     */
    public function store(StoreNodeRequest $request): JsonResponse
    {
        $node = $this->nodeService->addNode(
            $request->input('name'),
            $request->input('parent_id'),
            NodeType::from($request->input('type')),
            $request->input('zip_code'),
            $request->input('monthly_rent'),
        );

        return response()->json(NodeResource::make($node));
    }

    /**
     * @operationId Get a node
     */
    public function show(Node $node): JsonResponse
    {
        $node = $this->nodeService->getNode($node->id);

        return response()->json(NodeResource::make($node));
    }
}
