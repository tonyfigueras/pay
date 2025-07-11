<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Carbon
use Carbon\Carbon;

class Transaction extends Model
{
  use HasFactory, SoftDeletes;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'transable_id',
		'transable_type',
		'type',
		'payload',
		'amount',
		'previous_balance',
		'payment_method',
		'exonerado',
	];
	
	/**
	 * The attributes hiddeable.
	 *
	 * @var array
	 */
	protected $hidden = [
		'updated_at', 
		'deleted_at',
		'user_id', 
		'transable_id',
		'transable_type',
	];
	
	/**
	 * The attributes casteable.
	 *
	 * @var array
	 */
	protected $casts = [
		'amount' => 'float',
		'previous_balance' => 'float',
		'exonerado' => 'integer',
		'payload' => 'object',
	];
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function transable()
	{
		return $this->morphTo()->withTrashed();
	}
	
	/*
	 Attributos
	*/
	protected function createdAt(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => Carbon::parse($value)
			->timezone(config('app.timezone_parse'))
			->format('Y-m-d h:i A'),
		);
	}
}