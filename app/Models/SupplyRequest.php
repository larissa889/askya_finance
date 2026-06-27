<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'type',
        'agency_source_id',
        'agency_destination_id',
        'service_source_id',
        'service_destination_id',
        'cash_register_source_id',
        'cash_register_destination_id',
        'amount',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (SupplyRequest $request) {
            if (empty($request->reference)) {
                $request->reference = static::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;
        return 'APR-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function agencySource(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_source_id');
    }

    public function agencyDestination(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_destination_id');
    }

    public function serviceSource(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_source_id');
    }

    public function serviceDestination(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_destination_id');
    }

    public function cashRegisterSource(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_source_id');
    }

    public function cashRegisterDestination(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_destination_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
