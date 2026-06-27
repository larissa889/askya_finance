<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\SupplyRequest;
use App\Models\Agency;
use App\Models\Service;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $requests = SupplyRequest::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('caissier.supplies.index', compact('requests'));
    }

    public function create($type)
    {
        if (!in_array($type, ['client', 'product', 'agency', 'reversement'])) {
            abort(404);
        }

        $user = Auth::user();
        $services = Service::active()->get();
        $agencies = Agency::where('id', '!=', $user->agency_id)->active()->get();
        
        $myRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->where('status', 'open')
            ->first();

        return view('caissier.supplies.create', compact('type', 'services', 'agencies', 'myRegister'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:client,product,agency,reversement'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'service_source_id' => ['required_if:type,product', 'nullable', 'exists:services,id'],
            'service_destination_id' => ['required_if:type,product', 'nullable', 'exists:services,id'],
            'agency_source_id' => ['required_if:type,agency', 'nullable', 'exists:agencies,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        
        // Find cashier's open cash register
        $myRegister = CashRegister::where('assigned_to', $user->id)
            ->where('agency_id', $user->agency_id)
            ->where('status', 'open')
            ->first();

        if (!$myRegister) {
            return redirect()->back()->withInput()->with('error', 'Vous devez avoir une caisse ouverte pour cette opération.');
        }

        // Determine destination register
        $destinationRegisterId = $myRegister->id;
        $sourceRegisterId = null;

        // If it's a reversement, cashier sends money from their register to the main register of their agency
        if ($request->type === 'reversement') {
            $mainRegister = CashRegister::where('agency_id', $user->agency_id)
                ->where('type', 'main')
                ->first();

            if (!$mainRegister) {
                return redirect()->back()->withInput()->with('error', 'Aucune caisse principale configurée pour votre agence.');
            }
            
            if ($myRegister->balance < $request->amount) {
                return redirect()->back()->withInput()->with('error', 'Solde insuffisant dans votre caisse pour ce reversement.');
            }

            $sourceRegisterId = $myRegister->id;
            $destinationRegisterId = $mainRegister->id;
        }

        // If it's inter-agency, source agency main register will be debited
        if ($request->type === 'agency') {
            $sourceAgencyMainReg = CashRegister::where('agency_id', $request->agency_source_id)
                ->where('type', 'main')
                ->first();
            
            if ($sourceAgencyMainReg) {
                $sourceRegisterId = $sourceAgencyMainReg->id;
            }
        }

        SupplyRequest::create([
            'type' => $request->type === 'reversement' ? 'central' : $request->type, // reversement is a transfer between registers
            'agency_source_id' => $request->type === 'agency' ? $request->agency_source_id : null,
            'agency_destination_id' => $user->agency_id,
            'service_source_id' => $request->type === 'product' ? $request->service_source_id : null,
            'service_destination_id' => $request->type === 'product' ? $request->service_destination_id : null,
            'cash_register_source_id' => $sourceRegisterId,
            'cash_register_destination_id' => $destinationRegisterId,
            'amount' => $request->amount,
            'status' => 'pending',
            'created_by' => $user->id,
            'notes' => $request->notes,
        ]);

        $message = $request->type === 'reversement' 
            ? 'Demande de reversement soumise au superviseur pour validation.' 
            : 'Demande d\'approvisionnement soumise avec succès.';

        return redirect()->route('caissier.caisse.index')
            ->with('success', $message);
    }
}
