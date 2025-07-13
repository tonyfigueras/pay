<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Npc extends Model
{
    protected $fillable = [
        'world_id',
        'name',
        'slug',
        'x',
        'y',
        'z',
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }

    public function actions(): MorphMany
    {
        return $this->morphMany(Actions::class, 'actionable')->whereNull('parent_id');
    }

}
