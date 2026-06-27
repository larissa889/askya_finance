<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Agency;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:services'],
            'description' => ['nullable', 'string'],
        ]);

        Service::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service financier créé avec succès.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:services,code,' . $service->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $service->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service financier mis à jour avec succès.');
    }

    public function show(Service $service)
    {
        $operationTypes = $service->operationTypes()->get();
        $agencies = Agency::active()->get();
        return view('admin.services.show', compact('service', 'operationTypes', 'agencies'));
    }

    public function syncAgencies(Request $request, Service $service)
    {
        $request->validate([
            'agencies' => ['nullable', 'array'],
            'agencies.*' => ['exists:agencies,id'],
        ]);

        $agencies = $request->input('agencies', []);
        
        // Prepare sync data with default pivot values
        $syncData = [];
        foreach ($agencies as $agencyId) {
            $syncData[$agencyId] = ['is_active' => true];
        }

        $service->agencies()->sync($syncData);

        return redirect()->route('admin.services.show', $service)
            ->with('success', 'Agences associées avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service financier supprimé avec succès.');
    }
}
