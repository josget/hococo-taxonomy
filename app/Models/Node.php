<?php

namespace App\Models;

use App\Enums\NodeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property NodeType $type
 * @property int $height
 * @property int $parent_id
 * @property Node $parent
 * @property Collection $children
 * @property NodeAttribute $attribute
 */
class Node extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => NodeType::class,
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Node::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'parent_id');
    }

    public function attribute(): HasOne
    {
        return $this->hasOne(NodeAttribute::class);
    }
}
