<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoSave extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
