<?php

namespace App\Models;

use App\Modules\Users\Models\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role', 'agency_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
        ];
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
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Validated transactions by this user (supervisor).
     */
    public function validatedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'validated_by');
    }

    /**
     * Cash closes created by this user (cashier).
     */
    public function cashCloses(): HasMany
    {
        return $this->hasMany(CashClose::class);
    }

    /**
     * Validated cash closes by this user (supervisor).
     */
    public function validatedCashCloses(): HasMany
    {
        return $this->hasMany(CashClose::class, 'validated_by');
    }

    /**
     * The agency this user belongs to.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
