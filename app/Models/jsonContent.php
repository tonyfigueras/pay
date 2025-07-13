<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jsonContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
        'json_content'
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }
}
