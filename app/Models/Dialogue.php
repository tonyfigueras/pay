<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{
    use HasFactory;

    protected $fillable = [
        'dialogue_name',
        'step_id', // nullable
        'non_playable_character_id',
        'previous_dialogue_id',
        'previous_step_completed',
        'can_be_repeated',
    ];

    public function nonPlayableCharacter(){
        return $this->belongsTo(nonPlayableCharacter::class, 'non_playable_character_id');
    }

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function step(){
        return $this->belongsTo(Step::class);
    }
}
