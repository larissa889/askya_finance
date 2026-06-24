@extends('layouts.dashboard')

@section('title', 'Tableau de Bord - Superviseur')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Bonjour, {{ Auth::user()->name }}</h1>
        <p>Bienvenue sur votre espace de supervision. | {{ date('d/m/Y') }}</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-arrows-rotate"></i>
            </div>
            <div>
                <h3>{{ $statistiques['total_jour'] }}</h3>
                <p>Transactions du jour</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium warning">
            <div class="icon-box">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <h3>{{ $statistiques['en_attente'] }}</h3>
                <p>En attente</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <h3>{{ $statistiques['validées'] }}</h3>
                <p>Validées</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-circle-xmark"></i>
            </div>
            <div>
                <h3>{{ $statistiques['rejetées'] }}</h3>
                <p>Rejetées</p>
            </div>
        </div>
    </div>
</div>

<!-- Pending Validations Table -->
<div class="glass-card">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-clock text-primary fs-5"></i>
        <span>Transactions en attente de validation</span>
    </h4>
    
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Caissier</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions_en_attente as $transaction)
                <tr>
                    <td><strong>{{ $transaction['reference'] }}</strong></td>
                    <td>{{ $transaction['client'] }}</td>
                    <td>
                        @if($transaction['type'] === 'encaissement')
                            <span class="text-success fw-semibold"><i class="fas fa-arrow-trend-down me-1"></i> {{ ucfirst($transaction['type']) }}</span>
                        @else
                            <span class="text-danger fw-semibold"><i class="fas fa-arrow-trend-up me-1"></i> {{ ucfirst($transaction['type']) }}</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $transaction['caissier'] }}</td>
                    <td>{{ $transaction['date'] }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Valider -->
                            <form action="{{ route('superviseur.valider', $transaction['id']) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-custom btn-custom-success py-1.5 px-2.5" title="Valider la transaction">
                                    <i class="fas fa-check m-0"></i>
                                </button>
                            </form>
                            <!-- Rejeter -->
                            <button type="button" class="btn-custom btn-custom-danger py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $transaction['id'] }}" title="Rejeter la transaction">
                                <i class="fas fa-times m-0"></i>
                            </button>
                            <!-- Voir -->
                            <a href="{{ route('superviseur.show', $transaction['id']) }}" class="btn-custom btn-custom-primary py-1.5 px-3">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-check-double d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucune transaction en attente de validation.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modals de Rejet -->
@foreach($transactions_en_attente as $transaction)
<div class="modal fade" id="rejectModal{{ $transaction['id'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('superviseur.rejeter', $transaction['id']) }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white">Rejeter la transaction {{ $transaction['reference'] }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <div class="mb-3">
                        <label for="commentaire" class="form-label-custom">Commentaire de rejet *</label>
                        <textarea class="form-control form-control-custom" id="commentaire" name="commentaire" rows="4" required placeholder="Expliquez la raison du rejet..."></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-custom btn-custom-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
