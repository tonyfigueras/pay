<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
        'name',
        'slug',
        'x',
        'y',
        'z'
    ];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

}
