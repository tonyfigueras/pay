<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'content',
        'success_message',
        'meh_message',
        'failure_message',
    ];

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // HasMany relationship

    public function chat() {
        return $this->belongsTo(Chat::class);
    }
}
