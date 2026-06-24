@extends('layouts.dashboard')

@section('title', 'Soldes Agences')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('comptable.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Solde</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Solde et suivi des agences</h1>
        <p>Analysez les soldes des agences et l'historique complet des mouvements de trésorerie.</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <h3>{{ number_format($solde_info['solde_actuel'], 0, ',', ' ') }} FCFA</h3>
                <p>Solde actuel</p>
                <div class="text-muted small mt-2" style="font-size: 0.8rem;">
                    <i class="fas fa-clock me-1"></i>Mise à jour: {{ $solde_info['derniere_maj'] }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <h3>{{ number_format($solde_info['total_credits'], 0, ',', ' ') }} FCFA</h3>
                <p>Total crédits</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <h3>{{ number_format($solde_info['total_debits'], 0, ',', ' ') }} FCFA</h3>
                <p>Total débits</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h3>{{ number_format($solde_info['solde_disponible'], 0, ',', ' ') }} FCFA</h3>
                <p>Solde disponible</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="glass-card mb-4">
    <form action="{{ route('comptable.solde.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label-custom">Rechercher</label>
                <input type="text" class="form-control-custom" id="search" name="search" 
                       placeholder="Référence, description..." value="{{ $search }}">
            </div>
            <div class="col-md-3">
                <label for="date_debut" class="form-label-custom">Date début</label>
                <input type="date" class="form-control-custom" id="date_debut" name="date_debut" 
                       value="{{ $date_debut }}">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label-custom">Date fin</label>
                <input type="date" class="form-control-custom" id="date_fin" name="date_fin" 
                       value="{{ $date_fin }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn-custom btn-custom-primary w-100 py-2.5 justify-content-center">
                    <i class="fas fa-search"></i> Filtrer
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Operations List -->
<div class="glass-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h4 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-list text-primary fs-5"></i>
            <span>Historique des opérations</span>
        </h4>
        
        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('comptable.export') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn-custom py-2 px-3">
                    <i class="fas fa-file-pdf text-danger"></i> PDF
                </button>
            </form>
            <form action="{{ route('comptable.export') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="format" value="excel">
                <button type="submit" class="btn-custom btn-custom-success py-2 px-3">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Description</th>
                    <th>Crédit</th>
                    <th>Débit</th>
                    <th>Solde après</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operations as $operation)
                <tr>
                    <td><strong>{{ $operation['reference'] }}</strong></td>
                    <td>{{ $operation['description'] }}</td>
                    <td>
                        @if($operation['credit'] > 0)
                        <span class="text-success fw-bold">+{{ number_format($operation['credit'], 0, ',', ' ') }} FCFA</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($operation['debit'] > 0)
                        <span class="text-danger fw-bold">-{{ number_format($operation['debit'], 0, ',', ' ') }} FCFA</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td><strong class="text-white">{{ number_format($operation['solde_apres'], 0, ',', ' ') }} FCFA</strong></td>
                    <td>{{ $operation['date'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fas fa-folder-open d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucune opération trouvée pour la période sélectionnée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

