<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentLocation extends Model
{
    protected $fillable = [
        'user_id',
        'galaxy_id',
        'world_id',
        'x',
        'y',
        'z'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
