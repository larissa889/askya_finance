@extends('layouts.dashboard')

@section('title', 'Détails du Service')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}" class="text-primary text-decoration-none">Produits</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $service->name }}</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Produit {{ $service->name }}</h1>
            <p>Code: <strong>{{ $service->code }}</strong> | Statut: 
                @if($service->is_active)
                    <span class="badge-premium badge-premium-success">Actif</span>
                @else
                    <span class="badge-premium">Inactif</span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Association Agences -->
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-building-user text-primary me-2"></i>Agences proposant ce service</h4>
            <form action="{{ route('admin.services.sync-agencies', $service) }}" method="POST">
                @csrf
                <div class="d-flex flex-column gap-3 mb-4">
                    @php
                        $assignedAgencies = $service->agencies()->pluck('agencies.id')->toArray();
                    @endphp
                    @foreach($agencies as $agency)
                    <div class="form-check form-switch p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" 
                               id="agency_{{ $agency->id }}" name="agencies[]" value="{{ $agency->id }}"
                               {{ in_array($agency->id, $assignedAgencies) ? 'checked' : '' }} style="float: left; width: 2em; height: 1em;">
                        <label class="form-check-label text-white fw-bold" for="agency_{{ $agency->id }}">
                            {{ $agency->name }} ({{ $agency->code }})
                        </label>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                    <i class="fas fa-save"></i> Enregistrer les associations
                </button>
            </form>
        </div>
    </div>

    <!-- Types d'Opérations -->
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-sliders text-primary me-2"></i>Types d'opérations configurés</h4>
            <div class="table-responsive-custom mb-3">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Code</th>
                            <th>Frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operationTypes as $type)
                        <tr>
                            <td><strong>{{ $type->name }}</strong></td>
                            <td><span class="badge-premium badge-premium-info">{{ $type->code }}</span></td>
                            <td>{{ $type->fees ?? 0 }} %</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Aucun type d'opération configuré pour ce service.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
