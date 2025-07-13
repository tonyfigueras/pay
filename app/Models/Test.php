<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
        'weight'
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }

}
