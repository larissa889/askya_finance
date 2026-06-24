@extends('layouts.dashboard')

@section('title', 'Détails de l\'Utilisateur')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none">Utilisateurs</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Détails</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1><i class="fas fa-user me-2 text-primary"></i>Détails de l'utilisateur</h1>
        <p>Consultez les informations de profil et d'accès pour {{ $user->name }}.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <!-- Profile header -->
    <div class="d-flex align-items-center flex-column flex-sm-row text-center text-sm-start gap-4 pb-4 mb-4" style="border-bottom: 1px solid var(--border-glass);">
        <div class="rounded-circle d-flex align-items-center justify-content-center fw-extrabold text-white text-uppercase" style="width: 80px; height: 80px; font-size: 2.2rem; background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h3 class="fw-bold text-white mb-1">{{ $user->name }}</h3>
            <p class="text-muted mb-2">{{ $user->email }}</p>
            @if($user->role && $user->role->value === 'admin')
                <span class="badge-premium badge-premium-danger">Admin</span>
            @elseif($user->role && $user->role->value === 'superviseur')
                <span class="badge-premium badge-premium-warning">Superviseur</span>
            @elseif($user->role && $user->role->value === 'comptable')
                <span class="badge-premium badge-premium-success">Comptable</span>
            @elseif($user->role && $user->role->value === 'caissier')
                <span class="badge-premium badge-premium-info">Caissier</span>
            @else
                <span class="badge-premium">{{ $user->role ? ucfirst($user->role->value) : '-' }}</span>
            @endif
        </div>
    </div>

    <!-- Details list -->
    <div class="d-flex flex-column gap-2 mb-4">
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Identifiant (ID)</div>
            <div class="col-md-8 text-white fw-bold">#{{ $user->id }}</div>
        </div>
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Nom complet</div>
            <div class="col-md-8 text-white fw-semibold">{{ $user->name }}</div>
        </div>
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Adresse email</div>
            <div class="col-md-8 text-white">{{ $user->email }}</div>
        </div>
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Rôle plateforme</div>
            <div class="col-md-8">
                @if($user->role && $user->role->value === 'admin')
                    <span class="badge-premium badge-premium-danger">Admin</span>
                @elseif($user->role && $user->role->value === 'superviseur')
                    <span class="badge-premium badge-premium-warning">Superviseur</span>
                @elseif($user->role && $user->role->value === 'comptable')
                    <span class="badge-premium badge-premium-success">Comptable</span>
                @elseif($user->role && $user->role->value === 'caissier')
                    <span class="badge-premium badge-premium-info">Caissier</span>
                @else
                    <span class="badge-premium">-</span>
                @endif
            </div>
        </div>
        @if($user->agency)
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Agence affectée</div>
            <div class="col-md-8 text-white fw-semibold">{{ $user->agency->name }} ({{ $user->agency->code }})</div>
        </div>
        @endif
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Date de création</div>
            <div class="col-md-8 text-white">{{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : '-' }}</div>
        </div>
        <div class="row py-2.5 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Dernière modification</div>
            <div class="col-md-8 text-white">{{ $user->updated_at ? $user->updated_at->format('d/m/Y à H:i') : '-' }}</div>
        </div>
        <div class="row py-2.5 g-2" style="border-bottom: none;">
            <div class="col-md-4 text-muted small fw-bold text-uppercase">Statut e-mail</div>
            <div class="col-md-8">
                @if($user->email_verified_at)
                    <span class="badge-premium badge-premium-success">
                        <i class="fas fa-check-circle me-1"></i>Vérifié
                    </span>
                @else
                    <span class="badge-premium badge-premium-warning">
                        <i class="fas fa-clock me-1"></i>En attente
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions buttons -->
    <div class="d-flex gap-3 mt-5">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn-custom btn-custom-primary">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection

