@extends('layouts.dashboard')

@section('title', 'Mes Transactions')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div class="page-title">
        <h1>Mes transactions</h1>
        <p>Consultez et gérez toutes vos transactions enregistrées</p>
    </div>
    @if(isset($cashRegister) && $cashRegister->status === 'open')
        <!-- Si la caisse est ouverte, le caissier peut initier de nouvelles transactions via le dashboard ou directement -->
    @endif
</div>

<!-- Table Card -->
<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Reçu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->reference }}</strong></td>
                    <td>{{ $transaction->client_name }}</td>
                    <td>{{ $transaction->service ? $transaction->service->name : 'N/A' }}</td>
                    <td>
                        @if($transaction->type === 'encaissement')
                            <span class="text-success fw-semibold"><i class="fas fa-arrow-trend-down me-1"></i> {{ ucfirst($transaction->type) }}</span>
                        @else
                            <span class="text-danger fw-semibold"><i class="fas fa-arrow-trend-up me-1"></i> {{ ucfirst($transaction->type) }}</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y H:i') : $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($transaction->status === 'recorded')
                            <span class="badge-premium badge-premium-warning">Enregistrée</span>
                        @elseif($transaction->status === 'reconciled')
                            <span class="badge-premium badge-premium-success">Rapprochée</span>
                        @elseif($transaction->status === 'discrepancy')
                            <span class="badge-premium badge-premium-danger">En écart</span>
                        @elseif($transaction->status === 'compensated')
                            <span class="badge-premium badge-premium-info">Compensée</span>
                        @else
                            <span class="badge-premium">{{ ucfirst($transaction->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($transaction->receipt_path)
                        <div class="d-flex gap-2">
                            <a href="{{ asset($transaction->receipt_path) }}" target="_blank" class="btn-custom py-1.5 px-2.5" title="Voir le reçu">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <a href="{{ asset($transaction->receipt_path) }}" download class="btn-custom py-1.5 px-2.5" title="Télécharger le reçu">
                                <i class="fas fa-download m-0"></i>
                            </a>
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('caissier.transactions.show', $transaction->id) }}" class="btn-custom btn-custom-primary py-1.5 px-3">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-receipt d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucune transaction n'a été enregistrée pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
