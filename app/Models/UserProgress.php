<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
     protected $fillable = [
        'user_id',
        'world_id',
        'completed_actions',
        'unlocked_worlds',
        'last_played_at',
    ];

     protected $casts = [
        'completed_actions' => 'array',
        'unlocked_worlds' => 'array',
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
