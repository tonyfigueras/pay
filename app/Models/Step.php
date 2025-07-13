<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructions',
        'activity',
        'target_npc',
        'item',
        'minigame',
        'test_id',
        'quest_id',
        'order'
    ];

    public function quest(){
        return $this->belongsTo(Quest::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('completed')
            ->withTimestamps();
    }

    public function dialogues(){
        return $this->hasMany(Dialogue::class);
    }
}
