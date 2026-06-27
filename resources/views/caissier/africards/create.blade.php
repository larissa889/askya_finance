@extends('layouts.dashboard')

@section('title', 'Créer un Compte Africards')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Nouveau compte Africards</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Créer un Compte Africards</h1>
            <p>Enregistrez une nouvelle carte Africards pour un client.</p>
        </div>
        <a href="{{ route('caissier.dashboard') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <form action="{{ route('caissier.africards.store') }}" method="POST" class="d-flex flex-column gap-4">
        @csrf

        <div class="row g-3">
            <div class="col-md-12">
                <label for="card_number" class="form-label-custom">Numéro de carte Africards *</label>
                <input type="text" class="form-control form-control-custom @error('card_number') is-invalid @enderror" 
                       id="card_number" name="card_number" required placeholder="Ex: 4000 1234 5678 9010" value="{{ old('card_number') }}">
                @error('card_number')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <label for="client_name" class="form-label-custom">Nom complet du client *</label>
                <input type="text" class="form-control form-control-custom @error('client_name') is-invalid @enderror" 
                       id="client_name" name="client_name" required placeholder="Ex: Adama Ouédraogo" value="{{ old('client_name') }}">
                @error('client_name')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="client_phone" class="form-label-custom">Téléphone du client</label>
                <input type="text" class="form-control form-control-custom @error('client_phone') is-invalid @enderror" 
                       id="client_phone" name="client_phone" placeholder="Ex: +226 70 00 00 00" value="{{ old('client_phone') }}">
                @error('client_phone')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="client_id_number" class="form-label-custom">Numéro de pièce d'identité (CNIB/Passeport)</label>
                <input type="text" class="form-control form-control-custom @error('client_id_number') is-invalid @enderror" 
                       id="client_id_number" name="client_id_number" placeholder="Ex: B12345678" value="{{ old('client_id_number') }}">
                @error('client_id_number')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <i class="fas fa-save"></i> Enregistrer le Compte
            </button>
            <a href="{{ route('caissier.dashboard') }}" class="btn-custom px-4 py-2.5 text-decoration-none">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
