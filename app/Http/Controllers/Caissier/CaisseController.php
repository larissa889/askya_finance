<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CashRegister;
use App\Models\Transaction;

class CaisseController extends Controller
{
    /**
     * Affiche l'état de la caisse du caissier
     */
    public function index()
    {
        $user = Auth::user();
        
        // Trouver la caisse ou la créer si elle n'existe pas
        $cashRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->first();
            
        if (!$cashRegister) {
            $cashRegister = CashRegister::create([
                'code' => 'REG-' . $user->id . '-' . $user->agency->code,
                'name' => 'Caisse de ' . $user->name,
                'agency_id' => $user->agency_id,
                'assigned_to' => $user->id,
                'balance' => 0,
                'status' => 'closed',
                'is_active' => true,
            ]);
        }
        
        $today = now()->startOfDay();
        
        // Mouvements réels d'aujourd'hui
        $mouvementsRaw = Transaction::where('agency_id', $user->agency_id)
            ->where('created_by', $user->id)
            ->whereDate('created_at', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculer les encaissements et décaissements
        $encaissements = 0;
        $decaissements = 0;
        
        $mouvements = $mouvementsRaw->map(function ($mvt) use (&$encaissements, &$decaissements) {
            $isEncaissement = in_array($mvt->type, ['deposit', 'transfer']);
            if ($isEncaissement) {
                $encaissements += $mvt->amount;
            } else {
                $decaissements += $mvt->amount;
            }
            
            return [
                'reference' => $mvt->reference,
                'type' => $isEncaissement ? 'encaissement' : 'decaissement',
                'montant' => $mvt->amount,
                'description' => ($isEncaissement ? 'Dépôt/Envoi ' : 'Retrait/Paiement ') . ($mvt->service ? $mvt->service->name : '') . ' - ' . $mvt->client_name,
                'date' => $mvt->created_at->format('d/m/Y H:i')
            ];
        })->toArray();
        
        $caisse = [
            'ouverture' => $cashRegister->status === 'open' ? $cashRegister->balance : 0,
            'encaissements' => $encaissements,
            'decaissements' => $decaissements,
            'solde' => ($cashRegister->status === 'open' ? $cashRegister->balance : 0) + $encaissements - $decaissements,
            'date_ouverture' => $cashRegister->opened_at ? $cashRegister->opened_at->format('d/m/Y H:i') : null,
            'caissier' => $user->name,
            'statut' => $cashRegister->status
        ];

        return view('caissier.caisse.index', compact('caisse', 'mouvements', 'cashRegister'));
    }

    /**
     * Ouvre la caisse
     */
    public function ouvrir(Request $request)
    {
        $request->validate([
            'montant_ouverture' => ['required', 'numeric', 'min:0'],
        ]);

        $user = Auth::user();
        
        $cashRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->first();
            
        if (!$cashRegister) {
            $cashRegister = CashRegister::create([
                'code' => 'REG-' . $user->id . '-' . $user->agency->code,
                'name' => 'Caisse de ' . $user->name,
                'agency_id' => $user->agency_id,
                'assigned_to' => $user->id,
                'balance' => $request->montant_ouverture,
                'status' => 'open',
                'opened_at' => now(),
                'is_active' => true,
            ]);
        } else {
            $cashRegister->update([
                'status' => 'open',
                'balance' => $request->montant_ouverture,
                'opened_at' => now(),
                'closed_at' => null,
            ]);
        }

        return redirect()->route('caissier.caisse.index')
            ->with('success', 'Caisse ouverte avec succès.');
    }

    /**
     * Ferme la caisse
     */
    public function fermer(Request $request)
    {
        $user = Auth::user();
        
        $cashRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->first();
            
        if ($cashRegister) {
            $cashRegister->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);
        }

        return redirect()->route('caissier.caisse.index')
            ->with('success', 'Caisse fermée avec succès.');
    }
}
