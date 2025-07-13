<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'event_name',
        'order'
    ];

    public function quest(){
        return $this->belongsTo(Quest::class);
    }
}
