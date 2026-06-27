<?php

namespace App\Models;

use App\Modules\Users\Models\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['first_name', 'last_name', 'name', 'email', 'password', 'role', 'agency_id', 'phone', 'id_number', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Get the user's full name.
     */
    protected function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Set the user's name attribute.
     */
    protected function setNameAttribute(string $value): void
    {
        // Split the name into first_name and last_name
        $parts = explode(' ', $value, 2);
        $this->attributes['first_name'] = $parts[0] ?? '';
        $this->attributes['last_name'] = $parts[1] ?? '';
    }

    /**
     * Check if the user has a given role.
     */
    public function hasRole(UserRole|string $role): bool
    {
        $roleValue = $role instanceof UserRole ? $role->value : $role;
        return $this->role instanceof UserRole
            ? $this->role->value === $roleValue
            : $this->role === $roleValue;
    }

    /**
     * Transactions created by this user (cashier).
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    /**
     * Transactions approved by this user (supervisor).
     */
    public function approvedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'approved_by');
    }

    /**
     * Cash registers assigned to this user.
     */
    public function cashRegisters(): HasMany
    {
        return $this->hasMany(CashRegister::class, 'assigned_to');
    }

    /**
     * Compensation reports created by this user (accountant).
     */
    public function compensationReports(): HasMany
    {
        return $this->hasMany(CompensationReport::class, 'created_by');
    }

    /**
     * Compensation reports approved by this user (admin).
     */
    public function approvedCompensationReports(): HasMany
    {
        return $this->hasMany(CompensationReport::class, 'approved_by');
    }

    /**
     * The agency this user belongs to.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCashiers($query)
    {
        return $query->where('role', 'caissier');
    }

    public function scopeSupervisors($query)
    {
        return $query->where('role', 'superviseur');
    }

    public function scopeAccountants($query)
    {
        return $query->where('role', 'comptable');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}
