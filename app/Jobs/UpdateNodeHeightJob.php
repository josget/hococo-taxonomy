<?php

namespace App\Jobs;

use App\Models\Node;
use App\Services\NodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateNodeHeightJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $nodeId)
    {
    }

    public function handle(NodeService $nodeService): void
    {
        $node = Node::findOrFail($this->nodeId);

        $nodeService->updateHeight($node);
    }
}
