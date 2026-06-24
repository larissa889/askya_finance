@extends('layouts.dashboard')

@section('title', 'Toutes les Transactions')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Transactions</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Toutes les transactions</h1>
        <p>Suivez l'historique complet des flux financiers de l'agence.</p>
    </div>
</div>

<!-- Filters Card -->
<div class="glass-card mb-4">
    <form action="{{ route('superviseur.transactions.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <label for="search" class="form-label-custom">Rechercher</label>
                <input type="text" class="form-control-custom" id="search" name="search" 
                       placeholder="Client, référence..." value="{{ $search }}">
            </div>
            
            <div class="col-lg-3 col-md-6">
                <label for="statut" class="form-label-custom">Statut</label>
                <select class="form-control-custom form-select-custom" id="statut" name="statut">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ $statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="validée" {{ $statut == 'validée' ? 'selected' : '' }}>Validée</option>
                    <option value="rejetée" {{ $statut == 'rejetée' ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <label for="date_debut" class="form-label-custom">Date début</label>
                <input type="date" class="form-control-custom" id="date_debut" name="date_debut" 
                       value="{{ $date_debut }}">
            </div>
            
            <div class="col-lg-2 col-md-6">
                <label for="date_fin" class="form-label-custom">Date fin</label>
                <input type="date" class="form-control-custom" id="date_fin" name="date_fin" 
                       value="{{ $date_fin }}">
            </div>
            
            <div class="col-lg-2 col-md-12 d-flex align-items-end">
                <button type="submit" class="btn-custom btn-custom-primary w-100 py-2.5 justify-content-center">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Transactions Table -->
<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Service</th>
                    <th>Montant</th>
                    <th>Caissier</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
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
                    <td class="fw-bold">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $transaction['caissier'] }}</td>
                    <td>
                        @if($transaction['statut'] === 'en_attente')
                            <span class="badge-premium badge-premium-warning">En attente</span>
                        @elseif($transaction['statut'] === 'validée')
                            <span class="badge-premium badge-premium-success">Validée</span>
                        @elseif($transaction['statut'] === 'rejetée')
                            <span class="badge-premium badge-premium-danger">Rejetée</span>
                        @else
                            <span class="badge-premium">{{ ucfirst($transaction['statut']) }}</span>
                        @endif
                    </td>
                    <td>{{ $transaction['date'] }}</td>
                    <td>
                        <a href="{{ route('superviseur.show', $transaction['id']) }}" class="btn-custom btn-custom-primary py-1.5 px-3">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-receipt d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucune transaction ne correspond aux critères.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination" style="gap: 5px;">
            <li class="page-item disabled">
                <a class="page-link" href="#" style="background: rgba(255,255,255,0.02); border-color: var(--border-glass); color: var(--text-muted); border-radius: 10px;">Précédent</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#" style="background: var(--primary); border-color: var(--primary); color: white; border-radius: 10px; font-weight: 700;">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" style="background: rgba(255,255,255,0.02); border-color: var(--border-glass); color: var(--text-light); border-radius: 10px;">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" style="background: rgba(255,255,255,0.02); border-color: var(--border-glass); color: var(--text-light); border-radius: 10px;">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" style="background: rgba(255,255,255,0.02); border-color: var(--border-glass); color: var(--text-light); border-radius: 10px;">Suivant</a>
            </li>
        </ul>
    </div>
</div>
@endsection
