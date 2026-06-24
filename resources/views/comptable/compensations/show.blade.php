@extends('layouts.dashboard')

@section('title', 'Détails Compensation')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('comptable.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('comptable.compensations.index') }}" class="text-primary text-decoration-none">Compensations</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Détails</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Détails de la compensation</h1>
        <p>Référence: <strong>{{ $compensation['reference'] }}</strong></p>
    </div>
</div>

<div class="glass-card" style="max-width: 900px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 gap-3" style="border-bottom: 1px solid var(--border-glass);">
        <div>
            <h2 class="fw-bold text-white mb-2">{{ $compensation['reference'] }}</h2>
            @if($compensation['statut'] === 'en_attente')
                <span class="badge-premium badge-premium-warning">En attente</span>
            @elseif($compensation['statut'] === 'payée' || $compensation['statut'] === 'payé')
                <span class="badge-premium badge-premium-success">Payée</span>
            @elseif($compensation['statut'] === 'validée' || $compensation['statut'] === 'validé')
                <span class="badge-premium badge-premium-info">Validée</span>
            @else
                <span class="badge-premium">{{ ucfirst($compensation['statut']) }}</span>
            @endif
        </div>
        <div class="fs-2 fw-extrabold text-primary">
            {{ number_format($compensation['total'], 0, ',', ' ') }} FCFA
        </div>
    </div>

    <!-- Compensation Section -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-scale-balanced text-primary small"></i>
            <span>Détails de compensation</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Référence unique</div>
                <div class="col-md-8 text-white fw-bold">{{ $compensation['reference'] }}</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">ID Transaction associée</div>
                <div class="col-md-8 text-white fw-semibold">{{ $compensation['transaction'] }}</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Agence émettrice (Source)</div>
                <div class="col-md-8 text-white">{{ $compensation['agence_source'] }}</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Agence destinatrice</div>
                <div class="col-md-8 text-white">{{ $compensation['agence_destination'] }}</div>
            </div>
        </div>
    </div>

    <!-- Financial details -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-coins text-primary small"></i>
            <span>Règlement financier</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Montant principal</div>
                <div class="col-md-8 text-white">{{ number_format($compensation['montant'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Frais de compensation</div>
                <div class="col-md-8 text-white">{{ number_format($compensation['frais'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Total brut calculé</div>
                <div class="col-md-8 text-primary fw-extrabold fs-5">{{ number_format($compensation['total'], 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>

    <!-- System info -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-info-circle text-primary small"></i>
            <span>Système</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Date de création</div>
                <div class="col-md-8 text-white">{{ $compensation['date'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <a href="{{ route('comptable.compensations.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection
