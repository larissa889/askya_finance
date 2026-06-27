@extends('layouts.dashboard')

@section('title', 'Gestion de Caisse')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Ma caisse</h1>
        <p>Gérez votre caisse et suivez tous les mouvements financiers</p>
    </div>
</div>

<!-- Cash register Status Alert banner -->
@if($cashRegister->status === 'open')
<div class="alert-custom alert-custom-success d-flex flex-column p-4 rounded-4 mb-4 gap-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 w-100 border-bottom border-light border-opacity-10 pb-3">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-circle-check fs-4"></i>
            <div>
                <h5 class="fw-bold text-white mb-1">Caisse ouverte</h5>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Votre caisse est active depuis le <strong>{{ $caisse['date_ouverture'] }}</strong>.</p>
            </div>
        </div>
        <form action="{{ route('caissier.caisse.fermer') }}" method="POST">
            @csrf
            <button type="submit" class="btn-custom btn-custom-danger py-2 px-3">
                <i class="fas fa-door-closed me-2"></i>Fermer la caisse
            </button>
        </form>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100">
        <a href="{{ route('caissier.supplies.create', 'client') }}" class="btn-custom py-2 px-3">
            <i class="fas fa-user-plus text-primary"></i> Approvisionnement Client
        </a>
        <a href="{{ route('caissier.supplies.create', 'product') }}" class="btn-custom py-2 px-3">
            <i class="fas fa-exchange-alt text-warning"></i> Approvisionnement Inter-Produits
        </a>
        <a href="{{ route('caissier.supplies.create', 'agency') }}" class="btn-custom py-2 px-3">
            <i class="fas fa-building text-info"></i> Approvisionnement Inter-Agences
        </a>
        <a href="{{ route('caissier.supplies.create', 'reversement') }}" class="btn-custom py-2 px-3">
            <i class="fas fa-reply text-danger"></i> Faire un Reversement
        </a>
    </div>
</div>
@else
<div class="alert-custom alert-custom-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center p-4 rounded-4 mb-4 gap-3">
    <div class="d-flex align-items-center gap-3">
        <i class="fas fa-triangle-exclamation fs-4"></i>
        <div>
            <h5 class="fw-bold text-white mb-1">Caisse fermée</h5>
            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Vous devez ouvrir votre caisse pour enregistrer des transactions financières.</p>
        </div>
    </div>
    <button type="button" class="btn-custom btn-custom-primary py-2.5 px-4 w-100" data-bs-toggle="modal" data-bs-target="#ouvrirCaisseModal">
        <i class="fas fa-door-open me-2"></i>Ouvrir la caisse
    </button>
</div>
@endif

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-door-open"></i>
            </div>
            <div>
                <h3>{{ number_format($caisse['ouverture'], 0, ',', ' ') }} FCFA</h3>
                <p>Ouverture</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <h3>{{ number_format($caisse['encaissements'], 0, ',', ' ') }} FCFA</h3>
                <p>Encaissements</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <h3>{{ number_format($caisse['decaissements'], 0, ',', ' ') }} FCFA</h3>
                <p>Décaissements</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <h3>{{ number_format($caisse['solde'], 0, ',', ' ') }} FCFA</h3>
                <p>Solde actuel</p>
            </div>
        </div>
    </div>
</div>

<!-- Movements Table -->
<div class="glass-card">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-history text-primary fs-5"></i>
        <span>Mouvements récents de la caisse</span>
    </h4>
    
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mouvements as $mouvement)
                <tr>
                    <td><strong>{{ $mouvement['reference'] }}</strong></td>
                    <td>
                        @if($mouvement['type'] === 'encaissement')
                            <span class="badge-premium badge-premium-success">Encaissement</span>
                        @else
                            <span class="badge-premium badge-premium-danger">Décaissement</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ number_format($mouvement['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $mouvement['description'] }}</td>
                    <td>{{ $mouvement['date'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucun mouvement enregistré pour cette session.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ouvrir la caisse -->
<div class="modal fade" id="ouvrirCaisseModal" tabindex="-1" aria-labelledby="ouvrirCaisseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('caissier.caisse.ouvrir') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white" id="ouvrirCaisseModalLabel">Ouvrir la caisse</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <div class="mb-3">
                        <label for="montant_ouverture" class="form-label-custom">Montant d'ouverture (FCFA)</label>
                        <input type="number" class="form-control form-control-custom" id="montant_ouverture" name="montant_ouverture" min="0" required value="0">
                        <div class="text-muted small mt-2">Spécifiez le montant en espèces présent physiquement dans la caisse au moment de son ouverture.</div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn-custom" data-bs-modal="modal" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-custom btn-custom-primary">Confirmer l'ouverture</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
