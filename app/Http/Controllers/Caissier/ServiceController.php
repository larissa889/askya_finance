<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\OperationType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Affiche les détails d'un service
     */
    public function show($code)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            abort(403, 'Vous n\'êtes pas assigné à une agence.');
        }
        
        // Récupérer le service par son code
        $service = Service::where('code', $code)->firstOrFail();
        
        // Vérifier que le service est disponible pour l'agence du caissier
        $agencyServices = $user->agency->activeServices()->pluck('services.id')->toArray();
        
        if (!in_array($service->id, $agencyServices)) {
            abort(403, 'Ce service n\'est pas disponible pour votre agence.');
        }
        
        // Récupérer les types d'opérations pour ce service
        $operationTypes = OperationType::where('service_id', $service->id)
            ->active()
            ->get();
        
        return view('caissier.services.show', compact(
            'service',
            'operationTypes'
        ));
    }

    /**
     * Retourne les types d'opérations pour un service (AJAX)
     */
    public function getOperationTypes($serviceId)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a une agence
        if (!$user->agency_id) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        // Vérifier que le service est disponible pour l'agence
        $agencyServices = $user->agency->activeServices()->pluck('services.id')->toArray();
        if (!in_array($serviceId, $agencyServices)) {
            return response()->json(['error' => 'Service non disponible'], 403);
        }
        
        $operationTypes = OperationType::where('service_id', $serviceId)
            ->active()
            ->get();
        
        return response()->json($operationTypes);
    }
}
