<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AfricardsAccount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_number',
        'client_name',
        'client_phone',
        'client_id_number',
        'agency_id',
        'created_by',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
