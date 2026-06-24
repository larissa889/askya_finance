@extends('layouts.dashboard')

@section('title', 'Validation des Transactions')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Validations</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Validation des transactions</h1>
        <p>Validez ou rejetez les transactions enregistrées par les caissiers de votre agence.</p>
    </div>
</div>

<!-- Pending Validations Table -->
<div class="glass-card">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-list-check text-primary fs-5"></i>
        <span>Transactions en attente</span>
    </h4>
    
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Service</th>
                    <th>Montant</th>
                    <th>Frais</th>
                    <th>Total</th>
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
                    <td>{{ $transaction['service'] }}</td>
                    <td>{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($transaction['frais'], 0, ',', ' ') }} FCFA</td>
                    <td class="fw-bold text-white">{{ number_format($transaction['total'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $transaction['caissier'] }}</td>
                    <td>{{ $transaction['date'] }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Valider -->
                            <form action="{{ route('superviseur.valider', $transaction['id']) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-custom btn-custom-success py-1.5 px-2.5" title="Valider">
                                    <i class="fas fa-check m-0"></i>
                                </button>
                            </form>
                            <!-- Rejeter -->
                            <button type="button" class="btn-custom btn-custom-danger py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $transaction['id'] }}" title="Rejeter">
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
                    <td colspan="10" class="text-center text-muted py-5">
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
                        <textarea class="form-control form-control-custom" id="commentaire" name="commentaire" rows="4" required placeholder="Saisissez la justification du rejet de cette transaction..."></textarea>
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
