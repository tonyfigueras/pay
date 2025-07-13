<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'type',
        'price',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'product_user', 'user_id', 'product_id');
    }
}
