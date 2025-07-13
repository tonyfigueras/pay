<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
        'name',
        'description',
        'order'
    ];

    public function world(){
        return $this->belongsTo(World::class);
    }

    public function quests(){
        return $this->hasMany(Quest::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('completed') // Assuming 'completed' is a column in the pivot table
            ->withTimestamps();
    }
}
