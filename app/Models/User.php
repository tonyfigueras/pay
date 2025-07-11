<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
	 * Esta parte arregla cambia el guard name default del usuario
	 * para que no de problemas al utilizar procesos en segundo
	 * plano que den permisos a usuarios.
	 */
	protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
		'name',
		'email',
		'password',
		'avatar',
		'privilegio',
		'actived_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'username',
		'name',
		'email',
		'password',
		'avatar',
		'privilegio',
		'actived_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wallet()
	{
		return $this->hasOne(Wallet::class)->withTrashed();
	}

    public function personal_data()
	{
		return $this->morphTo()->withTrashed();
	}

    public function logs()
	{
		return $this->hasMany(Log::class);
	}

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    // Relación a través del usuario
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function blocks()
	{
		return $this->hasOne(Block::class);
	}
}
