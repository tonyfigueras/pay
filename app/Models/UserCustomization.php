<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCustomization extends Model
{
    protected $fillable = [
        'user_id',
        'skin_color',
        'hair_color',
        'eyes_color',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
