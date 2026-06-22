<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'manager',
        'cash_balance',
        'electronic_balance',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cash_balance' => 'decimal:2',
        'electronic_balance' => 'decimal:2',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function cashCloses(): HasMany
    {
        return $this->hasMany(CashClose::class);
    }

    public function updateBalances($cashAmount, $electronicAmount)
    {
        $this->cash_balance += $cashAmount;
        $this->electronic_balance += $electronicAmount;
        $this->save();
    }
}
