<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashRegister;
use App\Models\Agency;
use App\Models\Bank;
use App\Models\User;
use App\Models\SupplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashRegisterController extends Controller
{
    public function index()
    {
        $registers = CashRegister::with(['agency', 'bank', 'assignedTo'])->get();
        return view('admin.registers.index', compact('registers'));
    }

    public function create()
    {
        $agencies = Agency::active()->get();
        $banks = Bank::active()->get();
        $users = User::active()->get();
        return view('admin.registers.create', compact('agencies', 'banks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:cash_registers'],
            'type' => ['required', 'in:cashier,main,bank'],
            'agency_id' => ['required', 'exists:agencies,id'],
            'bank_id' => ['required_if:type,bank', 'nullable', 'exists:banks,id'],
            'assigned_to' => ['required_if:type,cashier', 'nullable', 'exists:users,id'],
            'balance' => ['required', 'numeric', 'min:0'],
        ]);

        CashRegister::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'agency_id' => $request->agency_id,
            'bank_id' => $request->type === 'bank' ? $request->bank_id : null,
            'assigned_to' => $request->type === 'cashier' ? $request->assigned_to : null,
            'balance' => $request->balance,
            'status' => 'closed',
            'is_active' => true,
        ]);

        return redirect()->route('admin.registers.index')
            ->with('success', 'Caisse créée avec succès.');
    }

    public function edit(CashRegister $register)
    {
        $agencies = Agency::active()->get();
        $banks = Bank::active()->get();
        $users = User::active()->get();
        return view('admin.registers.edit', compact('register', 'agencies', 'banks', 'users'));
    }

    public function update(Request $request, CashRegister $register)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:cash_registers,code,' . $register->id],
            'type' => ['required', 'in:cashier,main,bank'],
            'agency_id' => ['required', 'exists:agencies,id'],
            'bank_id' => ['required_if:type,bank', 'nullable', 'exists:banks,id'],
            'assigned_to' => ['required_if:type,cashier', 'nullable', 'exists:users,id'],
            'balance' => ['required', 'numeric'],
            'is_active' => ['required', 'boolean'],
        ]);

        $register->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'agency_id' => $request->agency_id,
            'bank_id' => $request->type === 'bank' ? $request->bank_id : null,
            'assigned_to' => $request->type === 'cashier' ? $request->assigned_to : null,
            'balance' => $request->balance,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.registers.index')
            ->with('success', 'Caisse mise à jour avec succès.');
    }

    public function show(CashRegister $register)
    {
        $histories = $register->transactions()->orderBy('created_at', 'desc')->limit(20)->get();
        return view('admin.registers.show', compact('register', 'histories'));
    }

    public function feed(Request $request, CashRegister $register)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1000'],
            'notes' => ['nullable', 'string'],
        ]);

        // Transfer funds from seat to register (caisse principale or caisse banque)
        $register->balance += $request->amount;
        $register->save();

        // Create SupplyRequest record representing central funding
        SupplyRequest::create([
            'type' => 'central',
            'agency_destination_id' => $register->agency_id,
            'cash_register_destination_id' => $register->id,
            'amount' => $request->amount,
            'status' => 'approved',
            'created_by' => Auth::id(),
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes ?? 'Approvisionnement direct par l\'administrateur depuis la caisse principale.',
        ]);

        return redirect()->route('admin.registers.show', $register)
            ->with('success', 'Approvisionnement de ' . number_format($request->amount, 0, ',', ' ') . ' FCFA effectué avec succès.');
    }

    public function destroy(CashRegister $register)
    {
        $register->delete();
        return redirect()->route('admin.registers.index')
            ->with('success', 'Caisse supprimée avec succès.');
    }
}
