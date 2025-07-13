<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'world_id',
        'name'
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }
}
