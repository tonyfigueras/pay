<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AreaTriggerEvent extends Model
{

    protected $fillable = [
        'world_id',
        'name',
        'slug',
        'shape',
        'x',
        'y',
        'z',
        'size',
        'actions_type',
        'auto_trigger',
        'disabled',
    ];

     protected $casts = [
        'x' => 'float',
        'y' => 'float',
        'z' => 'float',
        'size' => 'array',   
        'auto_trigger' => 'boolean',
        'disabled' => 'boolean',
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }

    public function actions(): MorphMany
{
    return $this->morphMany(Actions::class, 'actionable')
        ->with(['children' => function ($query) {
            $query->with('children')->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->orderBy('order');
}
}
