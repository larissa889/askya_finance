@extends('layouts.dashboard')

@section('title', 'Détails de l\'Agence')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.agencies.index') }}" class="text-primary text-decoration-none">Agences</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $agency->name }}</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Agence {{ $agency->name }}</h1>
            <p>Code: <strong>{{ $agency->code }}</strong> | Manager: <strong>{{ $agency->manager ?? 'N/A' }}</strong></p>
        </div>
        <a href="{{ route('admin.agencies.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-circle-info text-primary me-2"></i>Informations générales</h4>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Adresse :</span>
                    <span class="text-white fw-bold">{{ $agency->address ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Téléphone :</span>
                    <span class="text-white fw-bold">{{ $agency->phone ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Email :</span>
                    <span class="text-white fw-bold">{{ $agency->email ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Encaisse physique :</span>
                    <span class="text-success fw-bold">{{ number_format($agency->cash_balance, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Solde électronique :</span>
                    <span class="text-info fw-bold">{{ number_format($agency->electronic_balance, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-users-gear text-primary me-2"></i>Personnel de l'agence</h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>
                                @if($user->role->value === 'caissier')
                                    <span class="badge-premium badge-premium-info">Caissier</span>
                                @elseif($user->role->value === 'superviseur')
                                    <span class="badge-premium badge-premium-warning">Superviseur</span>
                                @else
                                    <span class="badge-premium">{{ $user->role->label() }}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge-premium badge-premium-success">Actif</span>
                                @else
                                    <span class="badge-premium">Inactif</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Aucun utilisateur affecté à cette agence.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
