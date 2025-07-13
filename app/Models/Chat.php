<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'dialogue_id',
        'order',
        'content'
    ];

    public function dialogue() {
        return $this->belongsTo(Dialogue::class);
    }

    public function question() {
        return $this->hasOne(Question::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
