<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'agency_id',
        'service_id',
        'operation_type_id',
        'user_id',
        'transaction_date',
        'transaction_time',
        'transaction_number',
        'client_name',
        'client_phone',
        'client_id_number',
        'amount',
        'fees',
        'total',
        'currency',
        'observations',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
        'is_historical',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'transaction_time' => 'datetime:H:i:s',
        'amount' => 'decimal:2',
        'fees' => 'decimal:2',
        'total' => 'decimal:2',
        'validated_at' => 'datetime',
        'is_historical' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Transaction $transaction) {
            if (empty($transaction->transaction_number)) {
                $transaction->transaction_number = static::generateTransactionNumber();
            }
            if (empty($transaction->total)) {
                $transaction->total = $transaction->amount + $transaction->fees;
            }
        });
    }

    public static function generateTransactionNumber(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('transaction_date', now()->toDateString())->count() + 1;
        return 'TRX-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
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
        return $query->whereDate('transaction_date', $date);
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
