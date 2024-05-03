<?php

namespace App\Http\Controllers\Node;

use App\Http\Controllers\Controller;
use App\Http\Requests\Node\ChangeParentNodeRequest;
use App\Http\Resources\Node\NodeResource;
use App\Jobs\UpdateNodeHeightJob;
use App\Models\Node;
use App\Services\NodeService;
use Illuminate\Http\JsonResponse;

class ChangeParentNodeController extends Controller
{
    public function __construct(readonly private NodeService $nodeService)
    {
    }

    /**
     * @operationId Change parent node
     *
     */
    public function __invoke(ChangeParentNodeRequest $request, Node $node): JsonResponse
    {
        $updatedNode = $this->nodeService->changeParentNode(
            $node,
            $request->input('parent_id')
        );

        dispatch(new UpdateNodeHeightJob($updatedNode->id));

        return response()->json(NodeResource::make($updatedNode->fresh()));
    }
}
