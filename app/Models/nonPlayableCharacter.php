<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nonPlayableCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "world_id",
        "quest_id",
        "active"
    ];

    public function quest(){
        return $this->belongsTo(Quest::class);
    }

    public function dialogues(){
        return $this->hasMany(Dialogue::class, 'non_playable_character_id');
    }

    public function world(){
        return $this->belongsTo(World::class);
    }
}
