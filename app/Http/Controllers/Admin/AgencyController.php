<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::orderBy('name')->get();
        return view('admin.agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('admin.agencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:agencies'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'manager' => ['nullable', 'string', 'max:255'],
        ]);

        Agency::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'manager' => $request->manager,
            'is_active' => true,
            'cash_balance' => 0,
            'electronic_balance' => 0,
        ]);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agence créée avec succès.');
    }

    public function show(Agency $agency)
    {
        $users = $agency->users()->get();
        return view('admin.agencies.show', compact('agency', 'users'));
    }

    public function edit(Agency $agency)
    {
        return view('admin.agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:agencies,code,' . $agency->id],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'manager' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);

        $agency->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'manager' => $request->manager,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agence mise à jour avec succès.');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('admin.agencies.index')
            ->with('success', 'Agence supprimée avec succès.');
    }
}
