<?php

use App\Enums\NodeType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')
                ->nullable()
                ->references('id')
                ->on('nodes')
                ->nullOnDelete();
            $table->unsignedInteger('height')
                ->default(0);
            $table->enum('type', [
                NodeType::CORPORATION->value,
                NodeType::BUILDING->value,
                NodeType::PROPERTY->value,
            ])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
