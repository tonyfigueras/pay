<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    public function user()
	{
		return $this->morphOne('App\Models\User', 'personal_data');
	}
}
