<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Affiche la page de recherche
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all');
        
        $results = [];
        
        if ($query) {
            // Simulation de recherche
            // En production, cette recherche serait effectuée en base de données
            $results = [
                [
                    'type' => 'transaction',
                    'reference' => 'TRX-2024-001',
                    'client' => 'Marie Kouassi',
                    'montant' => 50000,
                    'date' => '21/06/2024 10:30',
                    'statut' => 'validée'
                ],
                [
                    'type' => 'client',
                    'nom' => 'Marie Kouassi',
                    'telephone' => '+225 07 00 00 00 00',
                    'email' => 'marie.kouassi@email.com'
                ]
            ];
        }

        return view('caissier.search.index', compact('query', 'type', 'results'));
    }
}
