@extends('layouts.dashboard')

@section('title', 'Mon Profil')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Mon profil</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Mon profil</h1>
        <p>Gérez vos informations personnelles et vos paramètres de sécurité.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <!-- Profile header preview -->
    <div class="d-flex align-items-center flex-column flex-sm-row text-center text-sm-start gap-4 pb-4 mb-4" style="border-bottom: 1px solid var(--border-glass);">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff&size=128" alt="Avatar" class="rounded-circle" style="width: 90px; height: 90px; border: 3px solid rgba(59, 130, 246, 0.3);">
        <div>
            <h3 class="fw-bold text-white mb-1">{{ $user->name }}</h3>
            <p class="text-primary fw-semibold mb-1" style="font-size: 0.95rem;">{{ $user->role ? $user->role->label() : '' }}</p>
            <p class="text-muted small mb-0">Compte créé le {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</p>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('superviseur.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="name" class="form-label-custom">Nom complet *</label>
                <input type="text" class="form-control-custom @error('name') is-invalid @enderror" 
                       id="name" name="name" required value="{{ old('name', $user->name) }}">
                @error('name')
                <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="email" class="form-label-custom">Adresse e-mail *</label>
                <input type="email" class="form-control-custom @error('email') is-invalid @enderror" 
                       id="email" name="email" required value="{{ old('email', $user->email) }}">
                @error('email')
                <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-6">
                <label for="current_password" class="form-label-custom">Mot de passe actuel</label>
                <input type="password" class="form-control-custom @error('current_password') is-invalid @enderror" 
                       id="current_password" name="current_password" placeholder="Laisser vide pour ne pas changer">
                @error('current_password')
                <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="new_password" class="form-label-custom">Nouveau mot de passe</label>
                <input type="password" class="form-control-custom @error('new_password') is-invalid @enderror" 
                       id="new_password" name="new_password" placeholder="Nouveau mot de passe">
                @error('new_password')
                <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-6">
                <label for="new_password_confirmation" class="form-label-custom">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control-custom" 
                       id="new_password_confirmation" name="new_password_confirmation" 
                       placeholder="Confirmer le mot de passe">
            </div>
        </div>

        <div class="d-flex gap-3 mt-5">
            <button type="submit" class="btn-custom btn-custom-primary">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <a href="{{ route('superviseur.dashboard') }}" class="btn-custom">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
