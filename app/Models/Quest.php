<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'npc_triggerer',
        'order',
        'section_id',
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function steps(){
        return $this->hasMany(Step::class);
    }

    public function triggeringNpc()
    {
        return $this->belongsTo(QuestNpc::class, 'non_playable_character_id');
    }

    public function nonPlayableCharacters(){
        return $this->hasMany(NonPlayableCharacter::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('completed')
            ->withTimestamps();
    }

    public function tests(){
        return $this->hasMany(Test::class);
    }

    public function questEvents(){
        return $this->hasMany(QuestEvent::class);
    }
}
