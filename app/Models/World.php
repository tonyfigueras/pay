<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        'galaxy_id',
        'name',
        'slug',
        'description',
        'order',
        'glb',
        'default_spawn_x',
        'default_spawn_y',
        'default_spawn_z',
        'sections',
        'intro_seen',
        'tutorial_completed'
    ];

    protected $casts = [
        'sections' => 'array',
        'intro_seen' => 'boolean',
        'tutorial_completed' => 'boolean',
        'default_spawn_x' => 'float',
        'default_spawn_y' => 'float',  
        'default_spawn_z' => 'float' 
    ];

    // BelongsTo

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function galaxy(){
        return $this->belongsTo(Galaxy::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }

    // public function npcs(){
    //     return $this->hasMany(nonPlayableCharacter::class);
    // }

    public function npcs(){
             return $this->hasMany(Npc::class);
 }
    
    public function questnpcs(){
        return $this->hasMany(QuestNpc::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function tests(){
        return $this->hasMany(Test::class);
    }

    public function minigames(){
        return $this->hasMany(Minigame::class);
    }

    public function audios(){
        return $this->hasMany(Audio::class);
    }

    public function areaTriggerEvents(){
        return $this->hasMany(AreaTriggerEvent::class);
    }

    public function coins()
    {
        return $this->hasMany(Coin::class);
    }

}
