@extends('layouts.dashboard')

@section('title', 'Détails de la Caisse')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.registers.index') }}" class="text-primary text-decoration-none">Caisses</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $register->name }}</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Caisse {{ $register->name }}</h1>
            <p>Code: <strong>{{ $register->code }}</strong> | Statut: 
                @if($register->status === 'open')
                    <span class="badge-premium badge-premium-success">Ouverte</span>
                @else
                    <span class="badge-premium">Fermée</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            @if($register->type === 'main' || $register->type === 'bank')
            <button type="button" class="btn-custom btn-custom-success" data-bs-toggle="modal" data-bs-target="#feedRegisterModal">
                <i class="fas fa-plus"></i> Approvisionner depuis le Siège
            </button>
            @endif
            <a href="{{ route('admin.registers.index') }}" class="btn-custom">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-info-circle text-primary me-2"></i>Détails généraux</h4>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Type de caisse :</span>
                    <span class="text-white fw-bold">
                        @if($register->type === 'main')
                            Caisse Principale d'Agence
                        @elseif($register->type === 'bank')
                            Compte Bancaire
                        @else
                            Caisse Caissier
                        @endif
                    </span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Agence :</span>
                    <span class="text-white fw-bold">{{ $register->agency ? $register->agency->name : 'N/A' }}</span>
                </div>
                @if($register->type === 'bank')
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Banque :</span>
                    <span class="text-white fw-bold">{{ $register->bank ? $register->bank->name : 'N/A' }}</span>
                </div>
                @else
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Caissier assigné :</span>
                    <span class="text-white fw-bold">{{ $register->assignedTo ? $register->assignedTo->name : 'Non assignée' }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Solde actuel :</span>
                    <span class="text-success fw-extrabold fs-5">{{ number_format($register->balance, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-clock-history text-primary me-2"></i>Dernière ouverture / fermeture</h4>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Dernière ouverture :</span>
                    <span class="text-white fw-semibold">{{ $register->opened_at ? $register->opened_at->format('d/m/Y H:i') : 'Jamais ouverte' }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-light border-opacity-10 pb-2">
                    <span class="text-muted">Dernière fermeture :</span>
                    <span class="text-white fw-semibold">{{ $register->closed_at ? $register->closed_at->format('d/m/Y H:i') : 'Non fermée' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Notes système :</span>
                    <span class="text-white-50 small">{{ $register->notes ?? 'Aucune note' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-history text-primary me-2"></i>Historique des 20 dernières transactions</h4>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr>
                    <td><strong>{{ $history->reference }}</strong></td>
                    <td>
                        @if($history->type === 'deposit')
                            Dépôt
                        @elseif($history->type === 'withdraw')
                            Retrait
                        @elseif($history->type === 'transfer')
                            Transfert
                        @else
                            Paiement
                        @endif
                    </td>
                    <td class="fw-bold">{{ number_format($history->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $history->client_name }}</td>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($history->status === 'reconciled')
                            <span class="badge-premium badge-premium-success">Validée</span>
                        @elseif($history->status === 'recorded')
                            <span class="badge-premium badge-premium-warning">En attente</span>
                        @else
                            <span class="badge-premium badge-premium-danger">Rejetée</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucune transaction enregistrée pour cette caisse.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($register->type === 'main' || $register->type === 'bank')
<!-- Modal Approvisionner la caisse -->
<div class="modal fade" id="feedRegisterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('admin.registers.feed', $register) }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white">Approvisionner la caisse</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                    <div>
                        <label for="amount" class="form-label-custom">Montant à transférer (FCFA) *</label>
                        <input type="number" class="form-control form-control-custom" id="amount" name="amount" required min="1000" placeholder="Ex: 500000">
                    </div>
                    <div>
                        <label for="notes" class="form-label-custom">Notes / Motif du transfert</label>
                        <textarea class="form-control form-control-custom" id="notes" name="notes" rows="3" placeholder="Description de l'approvisionnement..."></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-custom btn-custom-success">Confirmer le Transfert</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
