<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $zip_code
 * @property string $monthly_rent
 */
class NodeAttribute extends Model
{
    protected $guarded = ['id'];
}
