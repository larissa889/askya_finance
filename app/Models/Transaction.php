<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'type',
        'amount',
        'fees',
        'total',
        'transaction_date',
        'status',
        'agency_id',
        'service_id',
        'operation_type_id',
        'created_by',
        'reconciled_by',
        'reconciled_at',
        'reconciliation_notes',
        'client_name',
        'client_phone',
        'client_id_number',
        'notes',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fees' => 'decimal:2',
        'total' => 'decimal:2',
        'transaction_date' => 'datetime',
        'reconciled_at' => 'datetime',
    ];

    public function getAskyaCommissionAttribute(): float
    {
        return (float) $this->fees * 0.60;
    }

    public function getBankCommissionAttribute(): float
    {
        return (float) $this->fees * 0.40;
    }

    public function getNetAmountAttribute(): float
    {
        return (float) $this->amount;
    }

    public function getPhoneNumberAttribute(): ?string
    {
        return $this->client_phone;
    }

    public function getServiceTypeAttribute(): ?string
    {
        return $this->service ? $this->service->name : null;
    }

    public function getTransactionTypeAttribute(): string
    {
        return $this->type;
    }

    /**
     * Boot: auto-generate unique reference on creation.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Transaction $transaction) {
            if (empty($transaction->reference)) {
                $transaction->reference = static::generateReference();
            }
        });
    }

    /**
     * Generate a unique transaction reference: TXN-YYYYMMDD-XXXX
     */
    public static function generateReference(): string
    {
        $date   = now()->format('Ymd');
        $count  = static::whereDate('created_at', now()->toDateString())->count() + 1;
        return 'TXN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reconciledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciled_by');
    }

    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    public function scopeRecorded($query)
    {
        return $query->where('status', 'recorded');
    }

    public function scopeReconciled($query)
    {
        return $query->where('status', 'reconciled');
    }

    public function scopeDiscrepancy($query)
    {
        return $query->where('status', 'discrepancy');
    }

    public function scopeCompensated($query)
    {
        return $query->where('status', 'compensated');
    }
}
