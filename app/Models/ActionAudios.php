<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Action;

class ActionAudios extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_id',
        'name',
        'path'
    ];

    public function action()
    {
        return $this->belongsTo(Actions::class);
    }
}
