<?php

use App\Enums\NodeType;
use App\Models\Node;

test('can change parent node', function () {
    $parentNode = Node::factory()->create([
        'name' => 'root',
        'type' => NodeType::BUILDING
    ]);

    $childNode = Node::factory()->create([
        'name' => 'a',
        'type' => NodeType::PROPERTY
    ]);

    $this->patchJson(
        route('nodes.change-parent-node', ['node' => $childNode->id]),
        [
            'parent_id' => $parentNode->id
        ]
    )
        ->assertSuccessful();
});

test('can not set parent node with Property type to a Building type node', function () {
    $parentNode = Node::factory()->create([
        'name' => 'root',
        'type' => NodeType::PROPERTY
    ]);

    $childNode = Node::factory()->create([
        'name' => 'a',
        'type' => NodeType::BUILDING
    ]);

    $this->patchJson(
        route('nodes.change-parent-node', ['node' => $childNode->id]),
        [
            'parent_id' => $parentNode->id
        ]
    )
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'parent_id' => 'A Building node cannot have a Property node as parent.'
        ]);
});

test('can not set parent node on its own', function () {
    $node = Node::factory()->create([
        'name' => 'a',
        'type' => NodeType::BUILDING
    ]);

    $this->patchJson(
        route('nodes.change-parent-node', ['node' => $node->id]),
        [
            'parent_id' => $node->id
        ]
    )
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'parent_id' => 'The parent node cannot be the node itself.'
        ]);
});

test('can update height of the affected nodes', function () {
    // ID = 1
    $this->postJson(route('nodes.store'), [
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ]);

    // ID = 2
    $this->postJson(route('nodes.store'), [
        'name' => 'a',
        'parent_id' => 1,
        'type' => NodeType::BUILDING,
        'zip_code' => "3333",
    ]);

    // ID = 3
    $this->postJson(route('nodes.store'), [
        'name' => 'c',
        'parent_id' => 2,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ]);

    // ID = 4
    $this->postJson(route('nodes.store'), [
        'name' => 'd',
        'parent_id' => 3,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ]);

    // ID = 5
    $this->postJson(route('nodes.store'), [
        'name' => 'e',
        'parent_id' => 3,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ]);

    // ID = 6
    $this->postJson(route('nodes.store'), [
        'name' => 'b',
        'parent_id' => 1,
        'type' => NodeType::BUILDING,
        'zip_code' => "3333",
    ]);

    expect(Node::firstWhere('name', 'c')->height)->toBe(2)
        ->and(Node::firstWhere('name', 'd')->height)->toBe(3)
        ->and(Node::firstWhere('name', 'e')->height)->toBe(3);

    $this->patchJson(
        route('nodes.change-parent-node', ['node' => Node::firstWhere('name', 'c')->id]),
        [
            'parent_id' => Node::firstWhere('name', 'root')->id
        ]
    );

    expect(Node::firstWhere('name', 'c')->height)->toBe(1)
        ->and(Node::firstWhere('name', 'd')->height)->toBe(2)
        ->and(Node::firstWhere('name', 'e')->height)->toBe(2);
});

