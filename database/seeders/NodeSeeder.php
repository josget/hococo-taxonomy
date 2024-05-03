<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Node;
use App\Services\NodeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Node::truncate();

        $corporation = Node::factory()->create([
            'name' => 'root',
            'type' => NodeType::CORPORATION
        ]);

        $building1 = Node::factory()->create([
            'name' => 'a',
            'parent_id' => $corporation->id,
            'type' => NodeType::BUILDING,
        ]);

        $building1->attribute()->create([
            'zip_code' => "3333"
        ]);

        $building2 = Node::factory()->create([
            'name' => 'c',
            'parent_id' => $building1->id,
            'type' => NodeType::BUILDING,
        ]);

        $building2->attribute()->create([
            'zip_code' => "3333",
        ]);

        $property2 = Node::factory()->create([
            'name' => 'd',
            'parent_id' => $building2->id,
            'type' => NodeType::PROPERTY,
        ]);

        $property2->attribute()->create([
            'monthly_rent' => 3333,
        ]);

        $property3 = Node::factory()->create([
            'name' => 'e',
            'parent_id' => $building2->id,
            'type' => NodeType::PROPERTY,
        ]);

        $property3->attribute()->create([
            'monthly_rent' => 3333,
        ]);

        $building3 = Node::factory()->create([
            'name' => 'b',
            'parent_id' => $corporation->id,
            'type' => NodeType::BUILDING,
        ]);

        $building3->attribute()->create([
            'zip_code' => "3333"
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        app(NodeService::class)->updateHeight($corporation);
    }
}
