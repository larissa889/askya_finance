@extends('layouts.dashboard')

@section('title', 'Activité du Caissier')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superviseur.cashiers.index') }}" class="text-primary text-decoration-none">Caissiers</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $cashier->name }}</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Activité de {{ $cashier->name }}</h1>
            <p>Consultez l'historique récent des opérations effectuées par ce caissier.</p>
        </div>
        <a href="{{ route('superviseur.cashiers.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-history text-primary me-2"></i>Dernières transactions enregistrées</h4>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Frais</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td><strong>{{ $t->reference }}</strong></td>
                    <td>
                        @if($t->type === 'deposit')
                            Dépôt
                        @elseif($t->type === 'withdraw')
                            Retrait
                        @elseif($t->type === 'transfer')
                            Transfert
                        @else
                            Paiement
                        @endif
                    </td>
                    <td class="fw-bold text-white">{{ number_format($t->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($t->fees, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $t->client_name }}</td>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($t->status === 'reconciled')
                            <span class="badge-premium badge-premium-success">Validée</span>
                        @elseif($t->status === 'recorded')
                            <span class="badge-premium badge-premium-warning">En attente</span>
                        @else
                            <span class="badge-premium badge-premium-danger">Rejetée</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucune transaction enregistrée par ce caissier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
