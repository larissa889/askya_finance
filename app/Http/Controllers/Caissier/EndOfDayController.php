<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\CashRegister;
use App\Models\CashRegisterHistory;
use Carbon\Carbon;

class EndOfDayController extends Controller
{
    /**
     * Affiche la fiche d'arrêt de fin de journée
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }

        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $dateCarbon = Carbon::parse($date);
        
        // Récupérer la caisse active du caissier
        $cashRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->where('status', 'open')
            ->first();

        if (!$cashRegister) {
            abort(403, 'Aucune caisse ouverte pour ce caissier.');
        }
        
        // Vérifier si l'historique existe déjà pour cette date
        $history = CashRegisterHistory::where('cash_register_id', $cashRegister->id)
            ->where('date', $date)
            ->first();

        // Récupérer les transactions du jour pour l'agence
        $transactions = Transaction::where('agency_id', $user->agency_id)
            ->whereDate('transaction_date', $date)
            ->with(['service', 'createdBy'])
            ->get();

        // Calculer les totaux basés sur les transactions
        $approvisionnementCompte = $transactions->where('type', 'deposit')->sum('amount');
        $paiementsCompte = $transactions->where('type', 'withdraw')->sum('amount');
        $depotsClientsCompte = $transactions->where('type', 'deposit')->sum('amount');
        $sortiesCompte = $transactions->where('type', 'withdraw')->sum('amount');
        
        $approvisionnementCaisse = $transactions->where('type', 'deposit')->sum('amount');
        $depotsClientsCaisse = $transactions->where('type', 'deposit')->sum('amount');
        $paiementsCaisse = $transactions->where('type', 'withdraw')->sum('amount');
        $sortiesCaisse = $transactions->where('type', 'withdraw')->sum('amount');
        
        $nombreTransactions = $transactions->count();

        // Si l'historique existe déjà, utiliser les valeurs enregistrées
        if ($history) {
            $soldeInitialCompte = $history->solde_initial_compte;
            $soldeInitialCaisse = $history->solde_initial_caisse;
            $ecartCompte = $history->ecart_compte;
            $ecartCaisse = $history->ecart_caisse;
            $soldeFinalCompte = $history->solde_final_compte;
            $soldeFinalCaisse = $history->solde_final_caisse;
        } else {
            // Récupérer le solde initial depuis l'historique du jour précédent
            $previousHistory = CashRegisterHistory::where('cash_register_id', $cashRegister->id)
                ->where('date', '<', $date)
                ->orderBy('date', 'desc')
                ->first();

            $soldeInitialCompte = $previousHistory ? $previousHistory->solde_final_compte : 0;
            $soldeInitialCaisse = $previousHistory ? $previousHistory->solde_final_caisse : 0;

            // Calculer les soldes finaux théoriques
            $soldeFinalCompte = $soldeInitialCompte + $approvisionnementCompte - $paiementsCompte + $depotsClientsCompte - $sortiesCompte;
            $soldeFinalCaisse = $soldeInitialCaisse + $approvisionnementCaisse + $depotsClientsCaisse - $paiementsCaisse - $sortiesCaisse;

            // Pour l'instant, l'écart est calculé comme la différence entre le solde théorique et le solde réel
            // Le solde réel devra être saisi manuellement ou récupéré depuis un comptage physique
            $ecartCompte = 0; // À calculer avec le solde réel
            $ecartCaisse = 0; // À calculer avec le solde réel
        }

        return view('caissier.end-of-day.index', compact(
            'transactions',
            'date',
            'cashRegister',
            'soldeInitialCompte',
            'approvisionnementCompte',
            'paiementsCompte',
            'depotsClientsCompte',
            'sortiesCompte',
            'ecartCompte',
            'soldeFinalCompte',
            'soldeInitialCaisse',
            'approvisionnementCaisse',
            'depotsClientsCaisse',
            'paiementsCaisse',
            'sortiesCaisse',
            'ecartCaisse',
            'soldeFinalCaisse',
            'nombreTransactions',
            'history'
        ));
    }

    /**
     * Enregistre la fiche d'arrêt
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }

        $request->validate([
            'date' => ['required', 'date'],
            'cash_register_id' => ['required', 'exists:cash_registers,id'],
            'solde_initial_compte' => ['required', 'numeric'],
            'approvisionnement_compte' => ['required', 'numeric'],
            'paiements_compte' => ['required', 'numeric'],
            'depots_clients_compte' => ['required', 'numeric'],
            'sorties_compte' => ['required', 'numeric'],
            'ecart_compte' => ['required', 'numeric'],
            'solde_final_compte' => ['required', 'numeric'],
            'solde_initial_caisse' => ['required', 'numeric'],
            'approvisionnement_caisse' => ['required', 'numeric'],
            'depots_clients_caisse' => ['required', 'numeric'],
            'paiements_caisse' => ['required', 'numeric'],
            'sorties_caisse' => ['required', 'numeric'],
            'ecart_caisse' => ['required', 'numeric'],
            'solde_final_caisse' => ['required', 'numeric'],
            'nombre_transactions' => ['required', 'integer'],
            'notes' => ['nullable', 'string'],
        ]);

        // Vérifier si l'historique existe déjà
        $history = CashRegisterHistory::where('cash_register_id', $request->cash_register_id)
            ->where('date', $request->date)
            ->first();

        if ($history) {
            $history->update($request->all());
        } else {
            CashRegisterHistory::create([
                'cash_register_id' => $request->cash_register_id,
                'agency_id' => $user->agency_id,
                'created_by' => $user->id,
                'date' => $request->date,
                'solde_initial_compte' => $request->solde_initial_compte,
                'approvisionnement_compte' => $request->approvisionnement_compte,
                'paiements_compte' => $request->paiements_compte,
                'depots_clients_compte' => $request->depots_clients_compte,
                'sorties_compte' => $request->sorties_compte,
                'ecart_compte' => $request->ecart_compte,
                'solde_final_compte' => $request->solde_final_compte,
                'solde_initial_caisse' => $request->solde_initial_caisse,
                'approvisionnement_caisse' => $request->approvisionnement_caisse,
                'depots_clients_caisse' => $request->depots_clients_caisse,
                'paiements_caisse' => $request->paiements_caisse,
                'sorties_caisse' => $request->sorties_caisse,
                'ecart_caisse' => $request->ecart_caisse,
                'solde_final_caisse' => $request->solde_final_caisse,
                'nombre_transactions' => $request->nombre_transactions,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('caissier.end-of-day.index', ['date' => $request->date])
            ->with('success', 'Fiche d\'arrêt enregistrée avec succès.');
    }
}
