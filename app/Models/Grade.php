<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'grade'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
