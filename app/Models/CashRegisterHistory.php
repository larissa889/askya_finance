<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CashRegisterHistory extends Model
{

    protected $fillable = [
        'cash_register_id',
        'agency_id',
        'created_by',
        'date',
        'solde_initial_compte',
        'approvisionnement_compte',
        'paiements_compte',
        'depots_clients_compte',
        'sorties_compte',
        'ecart_compte',
        'solde_final_compte',
        'solde_initial_caisse',
        'approvisionnement_caisse',
        'depots_clients_caisse',
        'paiements_caisse',
        'sorties_caisse',
        'ecart_caisse',
        'solde_final_caisse',
        'nombre_transactions',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'solde_initial_compte' => 'decimal:2',
        'approvisionnement_compte' => 'decimal:2',
        'paiements_compte' => 'decimal:2',
        'depots_clients_compte' => 'decimal:2',
        'sorties_compte' => 'decimal:2',
        'ecart_compte' => 'decimal:2',
        'solde_final_compte' => 'decimal:2',
        'solde_initial_caisse' => 'decimal:2',
        'approvisionnement_caisse' => 'decimal:2',
        'depots_clients_caisse' => 'decimal:2',
        'paiements_caisse' => 'decimal:2',
        'sorties_caisse' => 'decimal:2',
        'ecart_caisse' => 'decimal:2',
        'solde_final_caisse' => 'decimal:2',
        'nombre_transactions' => 'integer',
    ];

    public function cashRegister(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
