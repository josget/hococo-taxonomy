<?php

use App\Http\Controllers\Node\ChangeParentNodeController;
use App\Http\Controllers\Node\NodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('/nodes', NodeController::class)
        ->only(['index', 'store', 'show']);

    Route::patch('/nodes/{node}/change-parent-node', ChangeParentNodeController::class)
        ->name('nodes.change-parent-node');
});