<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestNpc extends Model
{
    use HasFactory;

    protected $table = "questnpcs";

    protected $fillable = [
        "world_id",
        "quest_id",
        "name",
    ];

    public function dialogues(){
        return $this->hasMany(Dialogue::class, 'non_playable_character_id');
    }

    public function quest(){
        return $this->hasMany(Quest::class, 'non_playable_character_id');
    }

    public function world(){
        return $this->belongsTo(World::class);
    }
}
