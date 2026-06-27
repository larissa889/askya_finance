@extends('layouts.dashboard')

@section('title', 'Demande d\'Approvisionnement')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('caissier.caisse.index') }}" class="text-primary text-decoration-none">Ma caisse</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Approvisionnement</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                @if($type === 'client')
                    Demande d'Approvisionnement Client
                @elseif($type === 'product')
                    Approvisionnement entre Produits
                @elseif($type === 'agency')
                    Approvisionnement Inter-Agences
                @else
                    Faire un Reversement au Siège
                @endif
            </h1>
            <p>Renseignez les détails pour initier la demande.</p>
        </div>
        <a href="{{ route('caissier.caisse.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <form action="{{ route('caissier.supplies.store') }}" method="POST" class="d-flex flex-column gap-4">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        @if($type === 'product')
        <!-- Between products selection -->
        <div class="row g-3">
            <div class="col-md-6">
                <label for="service_source_id" class="form-label-custom">Compte Produit Source (Débiter) *</label>
                <select class="form-control form-control-custom form-select-custom @error('service_source_id') is-invalid @enderror" 
                        id="service_source_id" name="service_source_id" required>
                    <option value="">Sélectionnez le produit source...</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_source_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_source_id')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="service_destination_id" class="form-label-custom">Compte Produit Destinataire (Créditer) *</label>
                <select class="form-control form-control-custom form-select-custom @error('service_destination_id') is-invalid @enderror" 
                        id="service_destination_id" name="service_destination_id" required>
                    <option value="">Sélectionnez le produit destinataire...</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_destination_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_destination_id')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @endif

        @if($type === 'agency')
        <!-- Inter-agency selection -->
        <div class="row g-3">
            <div class="col-md-12">
                <label for="agency_source_id" class="form-label-custom">Sélectionnez l'Agence Partenaire (Source) *</label>
                <select class="form-control form-control-custom form-select-custom @error('agency_source_id') is-invalid @enderror" 
                        id="agency_source_id" name="agency_source_id" required>
                    <option value="">Sélectionnez l'agence...</option>
                    @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ old('agency_source_id') == $agency->id ? 'selected' : '' }}>{{ $agency->name }} ({{ $agency->code }})</option>
                    @endforeach
                </select>
                @error('agency_source_id')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @endif

        <div class="row g-3">
            <div class="col-md-12">
                <label for="amount" class="form-label-custom">Montant (FCFA) *</label>
                <input type="number" class="form-control form-control-custom @error('amount') is-invalid @enderror" 
                       id="amount" name="amount" required min="1000" step="500" value="{{ old('amount') }}" placeholder="Ex: 250000">
                @error('amount')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <label for="notes" class="form-label-custom">Motif / Justification</label>
                <textarea class="form-control form-control-custom @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3" placeholder="Indiquez le motif de votre demande..." required>{{ old('notes') }}</textarea>
                @error('notes')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <i class="fas fa-paper-plane"></i> Envoyer la demande
            </button>
            <a href="{{ route('caissier.caisse.index') }}" class="btn-custom px-4 py-2.5 text-decoration-none">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
