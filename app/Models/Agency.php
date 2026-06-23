<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use SoftDeletes;

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

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'agency_service')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function cashRegisters(): HasMany
    {
        return $this->hasMany(CashRegister::class);
    }

    public function compensationReports(): HasMany
    {
        return $this->hasMany(CompensationReport::class);
    }

    public function activeServices(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'agency_service')
                    ->wherePivot('is_active', true)
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function updateBalances($cashAmount, $electronicAmount)
    {
        $this->cash_balance += $cashAmount;
        $this->electronic_balance += $electronicAmount;
        $this->save();
    }
}
