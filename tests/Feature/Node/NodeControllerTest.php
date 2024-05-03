<?php

use App\Enums\NodeType;
use App\Models\Node;

test('can fetch list of nodes', function () {
    Node::factory()->create([
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ]);

    $this->getJson(route('nodes.index'))
        ->assertSuccessful()
        ->assertJsonPath('0.name', 'root')
        ->assertJsonPath('0.type', NodeType::CORPORATION->value)
        ->assertJsonPath('0.height', 0)
        ->assertJsonCount(1);
});

test('can only add a unique node name', function () {
    Node::factory()->create([
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ]);


    $this->postJson(route('nodes.store'), [
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'name' => 'The name has already been taken.'
        ]);
});

test('can add a node if type is Corporation', function () {

    $this->postJson(route('nodes.store'), [
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ])
        ->assertSuccessful();

    $node = Node::first();

    expect(Node::count())->toBe(1)
        ->and($node->name)->toBe('root')
        ->and($node->type)->toBe(NodeType::CORPORATION);
});

test('zip code is required if type is Building', function () {
    $this->postJson(route('nodes.store'), [
        'name' => 'd',
        'type' => NodeType::BUILDING
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'zip_code' => 'The zip code field is required when type is Building.'
        ]);
});

test('monthly rent should be empty when type is not Property', function () {
    $this->postJson(route('nodes.store'), [
        'name' => 'c',
        'type' => NodeType::BUILDING,
        'monthly_rent' => 3333,
        'zip_code' => '3333'
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'monthly_rent' => 'A monthly rent must be null when type is Building.'
        ]);
});

test('monthly rent is required if type is Property', function () {
    $this->postJson(route('nodes.store'), [
        'name' => 'c',
        'type' => NodeType::PROPERTY
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'monthly_rent' => 'The monthly rent field is required when type is Property.'
        ]);
});

test('zip code should be empty when type is not Building', function () {
    $this->postJson(route('nodes.store'), [
        'name' => 'c',
        'type' => NodeType::BUILDING,
        'monthly_rent' => 3333,
        'zip_code' => '3333'
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'monthly_rent' => 'A monthly rent must be null when type is Building.'
        ]);
});

test('can create node with correct height', function () {
    // ID = 1
    $this->postJson(route('nodes.store'), [
        'name' => 'root',
        'type' => NodeType::CORPORATION
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 0);

    // ID = 2
    $this->postJson(route('nodes.store'), [
        'name' => 'a',
        'parent_id' => 1,
        'type' => NodeType::BUILDING,
        'zip_code' => "3333",
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 1);

    // ID = 3
    $this->postJson(route('nodes.store'), [
        'name' => 'c',
        'parent_id' => 2,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 2);

    // ID = 4
    $this->postJson(route('nodes.store'), [
        'name' => 'd',
        'parent_id' => 3,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 3);

    // ID = 5
    $this->postJson(route('nodes.store'), [
        'name' => 'e',
        'parent_id' => 3,
        'type' => NodeType::PROPERTY,
        'monthly_rent' => 3333,
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 3);

    // ID = 6
    $this->postJson(route('nodes.store'), [
        'name' => 'b',
        'parent_id' => 1,
        'type' => NodeType::BUILDING,
        'zip_code' => "3333",
    ])
        ->assertSuccessful()
        ->assertJsonPath('height', 1);
});


