<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompensationReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'agency_id',
        'created_by',
        'report_date',
        'start_date',
        'end_date',
        'internal_balance',
        'external_balance',
        'variance',
        'status',
        'approved_by',
        'approved_at',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'report_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'internal_balance' => 'decimal:2',
        'external_balance' => 'decimal:2',
        'variance' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (CompensationReport $report) {
            if (empty($report->reference)) {
                $report->reference = static::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;
        return 'COMP-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
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
