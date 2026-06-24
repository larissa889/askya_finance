@extends('layouts.dashboard')

@section('title', 'Transactions globales')

@section('styles')
<style>
    .pagination .page-link {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-glass);
        color: var(--text-muted);
        border-radius: 8px;
        margin: 0 3px;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }
    .pagination .page-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-light);
    }
    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        background: rgba(255, 255, 255, 0.01);
        border-color: var(--border-glass);
        color: rgba(255, 255, 255, 0.2);
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-exchange-alt me-2 text-primary"></i>Transactions globales</h1>
        <p>Consultez et gérez toutes les transactions de la plateforme</p>
    </div>
</div>

<!-- Filter Card -->
<div class="glass-card mb-4">
    <h4 class="mb-4 text-white"><i class="fas fa-filter me-2 text-primary"></i>Filtres</h4>
    <form action="{{ route('admin.transactions.index') }}" method="GET">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label-custom">Recherche</label>
                <input type="text" class="form-control-custom" name="search" value="{{ $search ?? '' }}" placeholder="Référence, client...">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label-custom">Statut</label>
                <select class="form-control-custom form-select-custom" name="statut">
                    <option value="">Tous</option>
                    <option value="validée" {{ ($statut ?? '') == 'validée' ? 'selected' : '' }}>Validée</option>
                    <option value="en_attente" {{ ($statut ?? '') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="annulée" {{ ($statut ?? '') == 'annulée' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label-custom">Caissier</label>
                <select class="form-control-custom form-select-custom" name="caissier">
                    <option value="">Tous</option>
                    <option value="marie_diop" {{ ($caissier ?? '') == 'marie_diop' ? 'selected' : '' }}>Marie Diop</option>
                    <option value="paul_yao" {{ ($caissier ?? '') == 'paul_yao' ? 'selected' : '' }}>Paul Yao</option>
                    <option value="jean_dupont" {{ ($caissier ?? '') == 'jean_dupont' ? 'selected' : '' }}>Jean Dupont</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label-custom">&nbsp;</label>
                <button type="submit" class="btn-custom btn-custom-primary w-100 justify-content-center">
                    <i class="fas fa-search me-2"></i>Filtrer
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label-custom">Date de début</label>
                <input type="date" class="form-control-custom" name="date_debut" value="{{ $date_debut ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label-custom">Date de fin</label>
                <input type="date" class="form-control-custom" name="date_fin" value="{{ $date_fin ?? '' }}">
            </div>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Client</th>
                    <th>Caissier</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td><strong class="text-white">{{ $transaction['reference'] }}</strong></td>
                    <td>{{ $transaction['type'] }}</td>
                    <td><span class="text-white fw-bold">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</span></td>
                    <td>{{ $transaction['client'] }}</td>
                    <td>{{ $transaction['caissier'] }}</td>
                    <td>
                        @php
                            $statusClass = $transaction['statut'] === 'validée' ? 'success' : ($transaction['statut'] === 'en_attente' ? 'warning' : 'danger');
                            $statusLabel = ucfirst(str_replace('_', ' ', $transaction['statut']));
                        @endphp
                        <span class="badge-premium badge-premium-{{ $statusClass }}">
                            <i class="fas {{ $statusClass === 'success' ? 'fa-circle-check' : ($statusClass === 'warning' ? 'fa-circle-dot' : 'fa-circle-xmark') }} me-1"></i>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td>{{ $transaction['date'] }}</td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $transaction['id']) }}" class="btn-custom py-1 px-3">
                            <i class="fas fa-eye text-primary"></i> Détails
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Aucune transaction trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Précédent</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Suivant</a>
            </li>
        </ul>
    </nav>
</div>
@endsection
