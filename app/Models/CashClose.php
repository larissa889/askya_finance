<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashClose extends Model
{
    protected $fillable = [
        'agency_id',
        'user_id',
        'close_date',
        'account_initial_balance',
        'account_provisioning',
        'account_payments',
        'account_deposits',
        'account_outputs',
        'account_variance',
        'account_final_balance',
        'cash_initial_balance',
        'cash_provisioning',
        'cash_deposits',
        'cash_payments',
        'cash_outputs',
        'cash_variance',
        'cash_final_balance',
        'transaction_count',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
        'observations',
        'is_historical',
    ];

    protected $casts = [
        'close_date' => 'date',
        'account_initial_balance' => 'decimal:2',
        'account_provisioning' => 'decimal:2',
        'account_payments' => 'decimal:2',
        'account_deposits' => 'decimal:2',
        'account_outputs' => 'decimal:2',
        'account_variance' => 'decimal:2',
        'account_final_balance' => 'decimal:2',
        'cash_initial_balance' => 'decimal:2',
        'cash_provisioning' => 'decimal:2',
        'cash_deposits' => 'decimal:2',
        'cash_payments' => 'decimal:2',
        'cash_outputs' => 'decimal:2',
        'cash_variance' => 'decimal:2',
        'cash_final_balance' => 'decimal:2',
        'transaction_count' => 'integer',
        'validated_at' => 'datetime',
        'is_historical' => 'boolean',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('close_date', $date);
    }

    public function scopeHistorical($query)
    {
        return $query->where('is_historical', true);
    }

    public function scopeNotHistorical($query)
    {
        return $query->where('is_historical', false);
    }
}
