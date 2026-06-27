<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord de l'administrateur
     */
    public function dashboard()
    {
        $admin = [
            'nom' => Auth::user()->name,
            'email' => Auth::user()->email,
            'photo' => 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0F172A&color=fff&size=128'
        ];

        $today = now()->toDateString();

        $statistiques = [
            'total_utilisateurs' => User::count(),
            'caissiers_actifs' => User::where('role', 'caissier')->where('is_active', true)->count(),
            'transactions_jour' => Transaction::whereDate('created_at', $today)->count(),
            'volume_financier' => Transaction::whereDate('created_at', $today)->sum('amount')
        ];

        $utilisateursRaw = User::orderBy('created_at', 'desc')->limit(5)->get();
        $utilisateurs = $utilisateursRaw->map(function ($u) {
            $roleValue = $u->role instanceof \BackedEnum ? $u->role->value : $u->role;
            return [
                'id' => $u->id,
                'nom' => $u->name,
                'role' => $roleValue,
                'email' => $u->email,
                'statut' => $u->is_active ? 'actif' : 'inactif',
                'date_creation' => $u->created_at->format('d/m/Y')
            ];
        });

        // Récupérer les logs récents ou régresser sur des actions fictives s'il n'y en a pas
        $logs = AuditLog::with('user')->orderBy('created_at', 'desc')->limit(5)->get();
        
        $activites = [];
        if ($logs->count() > 0) {
            foreach ($logs as $log) {
                $activites[] = [
                    'type' => $log->event,
                    'message' => $log->description,
                    'heure' => $log->created_at->diffForHumans(),
                    'icone' => match ($log->event) {
                        'login', 'connexion' => 'fa-sign-in-alt',
                        'create', 'creation' => 'fa-user-plus',
                        'update', 'modification' => 'fa-cog',
                        'delete', 'suppression' => 'fa-trash',
                        default => 'fa-info-circle'
                    }
                ];
            }
        } else {
            // Remplir avec des données basées sur les transactions réelles si aucun log
            $recentTransactions = Transaction::with('createdBy')->orderBy('created_at', 'desc')->limit(5)->get();
            foreach ($recentTransactions as $tx) {
                $activites[] = [
                    'type' => 'transaction',
                    'message' => "Transaction " . $tx->reference . " créée par " . $tx->createdBy->name,
                    'heure' => $tx->created_at->diffForHumans(),
                    'icone' => 'fa-check-circle'
                ];
            }
            if (empty($activites)) {
                $activites = [
                    [
                        'type' => 'systeme',
                        'message' => 'Système Askya Finance initialisé',
                        'heure' => 'À l\'instant',
                        'icone' => 'fa-cog'
                    ]
                ];
            }
        }

        return view('admin.dashboard', compact(
            'admin',
            'statistiques',
            'utilisateurs',
            'activites'
        ));
    }
}
