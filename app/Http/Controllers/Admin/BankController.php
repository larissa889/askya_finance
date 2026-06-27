<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\CashRegister;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('name')->get();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:banks'],
        ]);

        Bank::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'is_active' => true,
        ]);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Banque ajoutée avec succès.');
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:banks,code,' . $bank->id],
            'is_active' => ['required', 'boolean'],
        ]);

        $bank->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Banque mise à jour avec succès.');
    }

    public function show(Bank $bank)
    {
        // Get associated bank registers
        $registers = CashRegister::where('bank_id', $bank->id)->get();
        return view('admin.banks.show', compact('bank', 'registers'));
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('admin.banks.index')
            ->with('success', 'Banque supprimée avec succès.');
    }
}
