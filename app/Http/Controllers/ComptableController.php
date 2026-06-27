<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Agency;
use App\Models\CompensationReport;
use App\Models\CashRegisterHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComptableController extends Controller
{
    /**
     * Affiche le tableau de bord du comptable
     */
    public function dashboard()
    {
        $statistiques = [
            'a_regler' => CompensationReport::where('status', 'submitted')->sum('internal_balance'),
            'compenses' => CompensationReport::where('status', 'approved')->sum('internal_balance'),
            'solde_global' => Agency::sum('cash_balance') + Agency::sum('electronic_balance'),
            'operations' => Transaction::count()
        ];

        $compensationsRaw = CompensationReport::with(['agency'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $compensations = $compensationsRaw->map(function ($r) {
            $statutView = 'en_attente';
            if ($r->status === 'approved') {
                $statutView = 'paye';
            } elseif ($r->status === 'rejected') {
                $statutView = 'rejete';
            } elseif ($r->status === 'draft') {
                $statutView = 'brouillon';
            }

            return [
                'id' => $r->id,
                'reference' => $r->reference,
                'agence_source' => $r->agency ? $r->agency->name : 'N/A',
                'agence_dest' => 'Siège',
                'montant' => $r->internal_balance,
                'statut' => $statutView,
                'date' => $r->report_date ? $r->report_date->format('d/m/Y H:i') : $r->created_at->format('d/m/Y H:i')
            ];
        });

        return view('comptable.dashboard', compact(
            'statistiques',
            'compensations'
        ));
    }

    /**
     * Valide une compensation
     */
    public function validerCompensation(Request $request, $id)
    {
        $report = CompensationReport::findOrFail($id);
        $report->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => ($report->notes ? $report->notes . "\n" : "") . "Validé par le comptable.",
        ]);
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Compensation validée avec succès.');
    }

    /**
     * Marque une compensation comme payée
     */
    public function marquerPaye(Request $request, $id)
    {
        $report = CompensationReport::findOrFail($id);
        $report->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => ($report->notes ? $report->notes . "\n" : "") . "Marqué comme payé par le comptable.",
        ]);
        
        return redirect()->route('comptable.dashboard')
            ->with('success', 'Compensation marquée comme payée.');
    }

    /**
     * Affiche toutes les compensations
     */
    public function compensations(Request $request)
    {
        $search = $request->input('search');
        $statut = $request->input('statut');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $query = CompensationReport::with(['agency']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('agency', function($aq) use ($search) {
                      $aq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($statut) {
            $dbStatut = match($statut) {
                'payée' => 'approved',
                'en_attente' => 'submitted',
                'rejetée' => 'rejected',
                default => null
            };
            if ($dbStatut) {
                $query->where('status', $dbStatut);
            }
        }

        if ($date_debut) {
            $query->whereDate('report_date', '>=', $date_debut);
        }

        if ($date_fin) {
            $query->whereDate('report_date', '<=', $date_fin);
        }

        $compensationsRaw = $query->orderBy('created_at', 'desc')->get();

        $compensations = $compensationsRaw->map(function ($r) {
            $statutView = 'en_attente';
            if ($r->status === 'approved') {
                $statutView = 'payée';
            } elseif ($r->status === 'rejected') {
                $statutView = 'rejetée';
            }

            return [
                'id' => $r->id,
                'reference' => $r->reference,
                'transaction' => 'TRX-' . $r->id,
                'agence_source' => $r->agency ? $r->agency->name : 'N/A',
                'agence_destination' => 'Siège',
                'montant' => $r->internal_balance,
                'statut' => $statutView,
                'date' => $r->report_date ? $r->report_date->format('d/m/Y H:i') : $r->created_at->format('d/m/Y H:i')
            ];
        });

        return view('comptable.compensations.index', compact(
            'compensations',
            'search',
            'statut',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche les détails d'une compensation
     */
    public function showCompensation($id)
    {
        $r = CompensationReport::with(['agency'])->findOrFail($id);
        
        $statutView = 'en_attente';
        if ($r->status === 'approved') {
            $statutView = 'validée';
        } elseif ($r->status === 'rejected') {
            $statutView = 'rejetée';
        }

        $compensation = [
            'id' => $r->id,
            'reference' => $r->reference,
            'transaction' => 'TRX-' . $r->id,
            'agence_source' => $r->agency ? $r->agency->name : 'N/A',
            'agence_destination' => 'Siège',
            'montant' => $r->internal_balance,
            'frais' => $r->variance,
            'total' => $r->external_balance,
            'statut' => $statutView,
            'date' => $r->report_date ? $r->report_date->format('d/m/Y H:i') : $r->created_at->format('d/m/Y H:i')
        ];

        return view('comptable.compensations.show', compact('compensation'));
    }

    /**
     * Affiche les clôtures journalières à valider
     */
    public function closures()
    {
        $histories = CashRegisterHistory::with(['cashRegister', 'agency', 'createdBy'])
            ->orderBy('date', 'desc')
            ->get();
        return view('comptable.closures.index', compact('histories'));
    }

    /**
     * Valide une clôture journalière
     */
    public function validerClosure(Request $request, $id)
    {
        $history = CashRegisterHistory::findOrFail($id);
        $history->notes = ($history->notes ? $history->notes . "\n" : "") . "Validé par le comptable le " . now()->format('d/m/Y H:i') . ".";
        $history->save();

        return redirect()->route('comptable.closures.index')
            ->with('success', 'Clôture journalière validée avec succès.');
    }

    /**
     * Affiche le solde
     */
    public function solde(Request $request)
    {
        $search = $request->input('search');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $solde_info = [
            'solde_actuel' => Agency::sum('cash_balance') + Agency::sum('electronic_balance'),
            'total_credits' => Transaction::whereIn('type', ['deposit', 'transfer'])->sum('amount'),
            'total_debits' => Transaction::whereIn('type', ['withdraw', 'payment'])->sum('amount'),
            'solde_disponible' => Agency::sum('cash_balance') + Agency::sum('electronic_balance'),
            'derniere_maj' => now()->format('d/m/Y H:i')
        ];

        $query = Transaction::with(['agency', 'service']);
        
        if ($search) {
            $query->where('reference', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
        }
        
        if ($date_debut) {
            $query->whereDate('transaction_date', '>=', $date_debut);
        }
        
        if ($date_fin) {
            $query->whereDate('transaction_date', '<=', $date_fin);
        }

        $transactionsRaw = $query->orderBy('created_at', 'desc')->limit(20)->get();

        $operations = $transactionsRaw->map(function ($t) {
            $isCredit = in_array($t->type, ['deposit', 'transfer']);
            return [
                'id' => $t->id,
                'reference' => $t->reference,
                'description' => ($isCredit ? 'Crédit/Envoi ' : 'Débit/Retrait ') . ($t->service ? $t->service->name : '') . ' - ' . $t->client_name,
                'credit' => $isCredit ? $t->amount : 0,
                'debit' => !$isCredit ? $t->amount : 0,
                'solde_apres' => $t->total,
                'date' => $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : $t->created_at->format('d/m/Y H:i')
            ];
        });

        return view('comptable.solde.index', compact(
            'solde_info',
            'operations',
            'search',
            'date_debut',
            'date_fin'
        ));
    }

    /**
     * Affiche les rapports financiers
     */
    public function financialReports()
    {
        $statistiques = [
            'total_compensations' => CompensationReport::count(),
            'total_credits' => Transaction::whereIn('type', ['deposit', 'transfer'])->sum('amount'),
            'total_debits' => Transaction::whereIn('type', ['withdraw', 'payment'])->sum('amount'),
            'solde_global' => Agency::sum('cash_balance') + Agency::sum('electronic_balance')
        ];

        $days = collect();
        $data = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push($date->translatedFormat('l'));
            
            $bal = Agency::sum('cash_balance') + Agency::sum('electronic_balance');
            $data->push($bal);
        }

        $evolution_solde = [
            'labels' => $days->toArray(),
            'data' => $data->toArray()
        ];

        $compensations_periode = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            'data' => [
                CompensationReport::whereMonth('created_at', 1)->count(),
                CompensationReport::whereMonth('created_at', 2)->count(),
                CompensationReport::whereMonth('created_at', 3)->count(),
                CompensationReport::whereMonth('created_at', 4)->count(),
                CompensationReport::whereMonth('created_at', 5)->count(),
                CompensationReport::whereMonth('created_at', 6)->count(),
            ]
        ];

        $repartition_operations = [
            'labels' => ['Crédits', 'Débits'],
            'data' => [$statistiques['total_credits'], $statistiques['total_debits']]
        ];

        return view('comptable.reports.index', compact(
            'statistiques',
            'evolution_solde',
            'compensations_periode',
            'repartition_operations'
        ));
    }

    /**
     * Affiche le profil du comptable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('comptable.profile.index', compact('user'));
    }

    /**
     * Met à jour le profil du comptable
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return redirect()->route('comptable.profile.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
