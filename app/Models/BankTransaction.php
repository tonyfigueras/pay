<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
  use HasFactory;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'bank_account_id',
		'reference',
		'concepto',
		'amount',
		'date',
		'code',
		'user_id',
	];
	
	/**
	 * The attributes hiddeable.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at', 'user_id', 'bank_account_id',
	];
	
	/**
	 * The attributes casteable.
	 *
	 * @var array
	 */
	protected $casts = [
		'amount' => 'float',
		'reference' => 'integer',
		'concepto' => 'integer',
	];
	
	public function bank_account()
	{
		return $this->belongsTo(BankAccount::class);
	}
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function transaction()
	{
		return $this->morphOne('App\Models\WalletSystem\Transaction', 'transable');
	}
}
