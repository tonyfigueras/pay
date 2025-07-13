<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorldUser extends Model
{
     protected $table = 'world_user';

    protected $fillable = [
        'user_id',
        'world_id',
        'intro_seen',
        'tutorial_completed',
        'triggered_events',
        'locked',
        'completed',
        'is_active',
        'completed_at',
    ];

    protected $attributes = [
        'triggered_events' => '[]', 
    ];

    protected $casts = [
        'triggered_events' => 'array',
        'intro_seen' => 'boolean',
        'tutorial_completed' => 'boolean',
        'locked' => 'boolean',
        'completed' => 'boolean',
        'is_active' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function world()
    {
        return $this->belongsTo(World::class);
    }
}