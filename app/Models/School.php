<?php

// app/Models/School.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'rif', 'email', 
        'phone', 'address'
    ];

    // Relaciones
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function debtLotes()
    {
        return $this->hasMany(DebtLote::class);
    }

    // Todas las demás relaciones necesarias...
}