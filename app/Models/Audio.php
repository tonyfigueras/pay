<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $table = 'audios';

    protected $fillable = [
        'world_id',
        'name',
        'resources',
        'loop',
        'x',
        'y',
        'z',
        'distance',
        'maxDistance',
        'volumeDucking',
    ];

    protected $casts = [
        'loop' => 'boolean', 
        'x' => 'float',     
        'y' => 'float',    
        'z' => 'float',    
        'distance' => 'float',  
        'maxDistance' => 'float', 
        'volumeDucking' => 'array', 
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }
}
