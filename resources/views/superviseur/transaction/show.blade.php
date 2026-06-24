@extends('layouts.dashboard')

@section('title', 'Détails Transaction')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superviseur.transactions.index') }}" class="text-primary text-decoration-none">Transactions</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Détails</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Détails de la transaction</h1>
        <p>Référence: <strong>{{ $transaction['reference'] }}</strong></p>
    </div>
</div>

<div class="glass-card" style="max-width: 900px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 gap-3" style="border-bottom: 1px solid var(--border-glass);">
        <div>
            <h2 class="fw-bold text-white mb-2">{{ $transaction['reference'] }}</h2>
            @if($transaction['statut'] === 'en_attente')
                <span class="badge-premium badge-premium-warning">En attente</span>
            @elseif($transaction['statut'] === 'validée')
                <span class="badge-premium badge-premium-success">Validée</span>
            @elseif($transaction['statut'] === 'rejetée')
                <span class="badge-premium badge-premium-danger">Rejetée</span>
            @else
                <span class="badge-premium">{{ ucfirst($transaction['statut']) }}</span>
            @endif
        </div>
        <div class="fs-2 fw-extrabold text-primary">
            {{ number_format($transaction['total'], 0, ',', ' ') }} FCFA
        </div>
    </div>

    <!-- Client section -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-user text-primary small"></i>
            <span>Informations client</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Nom du client</div>
                <div class="col-md-8 text-white fw-semibold">{{ $transaction['client'] }}</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Téléphone</div>
                <div class="col-md-8 text-white">{{ $transaction['telephone'] }}</div>
            </div>
        </div>
    </div>

    <!-- Financial details section -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-coins text-primary small"></i>
            <span>Détails financiers</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Type d'opération</div>
                <div class="col-md-8 text-white fw-semibold">
                    @if($transaction['type'] === 'encaissement')
                        <span class="text-success"><i class="fas fa-arrow-trend-down me-1"></i> {{ ucfirst($transaction['type']) }}</span>
                    @else
                        <span class="text-danger"><i class="fas fa-arrow-trend-up me-1"></i> {{ ucfirst($transaction['type']) }}</span>
                    @endif
                </div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Montant net</div>
                <div class="col-md-8 text-white">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Frais</div>
                <div class="col-md-8 text-white">{{ number_format($transaction['frais'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Total</div>
                <div class="col-md-8 text-primary fw-extrabold fs-5">{{ number_format($transaction['total'], 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>

    <!-- System info section -->
    <div class="mb-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-info-circle text-primary small"></i>
            <span>Informations système</span>
        </h5>
        <div class="d-flex flex-column gap-2">
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Caissier opérationnel</div>
                <div class="col-md-8 text-white">{{ $transaction['caissier'] }}</div>
            </div>
            <div class="row py-2 g-2" style="border-bottom: 1px solid var(--border-glass);">
                <div class="col-md-4 text-muted small fw-bold text-uppercase">Date</div>
                <div class="col-md-8 text-white">{{ $transaction['date'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <a href="{{ route('superviseur.transactions.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection
