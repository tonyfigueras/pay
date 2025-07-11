<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
  use HasFactory;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'n_account',
		'rif',
		'name',
		'email',
		'type',
		'code',
	];
	
	/**
	 * The attributes hiddeable.
	 *
	 * @var array
	 */
	protected $hidden = [
		'updated_at', 'created_at',
	];
	
	public function bank_transactions()
	{
		return $this->hasMany(BankTransaction::class);
	}
	
	public function pending_payments()
	{
		return $this->hasMany(PendingPayment::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function getSchoolAttribute()
	{
		return $this->user->school;
	}
}
