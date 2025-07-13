<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galaxy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'under_construction'
    ];

    public function worlds(){
        return $this->hasMany(World::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
