<?php

namespace Database\Factories;

use App\Enums\NodeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class NodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => [
                NodeType::CORPORATION,
                NodeType::BUILDING,
                NodeType::PROPERTY
            ][rand(0, 2)],
            'parent_id' => null,
            'height' => 0,
        ];
    }
}
