@extends('layouts.dashboard')

@section('title', 'Tableau de Bord - Comptable')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Bonjour, {{ Auth::user()->name }}</h1>
        <p>Bienvenue sur votre espace comptable. | {{ date('d/m/Y') }}</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['a_regler'], 0, ',', ' ') }} FCFA</h3>
                <p>À régler</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['compenses'], 0, ',', ' ') }} FCFA</h3>
                <p>Compensés</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['solde_global'], 0, ',', ' ') }} FCFA</h3>
                <p>Solde global</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium warning">
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <h3>{{ $statistiques['operations'] }}</h3>
                <p>Opérations traitées</p>
            </div>
        </div>
    </div>
</div>

<!-- Compensations List -->
<div class="glass-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h4 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
            <i class="fas fa-scale-balanced text-primary fs-5"></i>
            <span>Compensations du jour</span>
        </h4>
        
        <div class="d-flex flex-wrap gap-2">
            <!-- Rapports -->
            <form action="{{ route('comptable.rapport') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-custom py-2 px-3">
                    <i class="fas fa-file-pdf text-danger"></i> Rapport PDF
                </button>
            </form>
            
            <form action="{{ route('comptable.export') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn-custom py-2 px-3">
                    <i class="fas fa-download"></i> PDF brut
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
                    <th>Agence Source</th>
                    <th>Agence Destinataire</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compensations as $compensation)
                <tr>
                    <td><strong>{{ $compensation['reference'] }}</strong></td>
                    <td>{{ $compensation['agence_source'] }}</td>
                    <td>{{ $compensation['agence_dest'] }}</td>
                    <td class="fw-bold text-white">{{ number_format($compensation['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($compensation['statut'] === 'en_attente')
                            <span class="badge-premium badge-premium-warning">En attente</span>
                        @elseif($compensation['statut'] === 'paye' || $compensation['statut'] === 'payé')
                            <span class="badge-premium badge-premium-success">Payée</span>
                        @elseif($compensation['statut'] === 'valide' || $compensation['statut'] === 'validé')
                            <span class="badge-premium badge-premium-info">Validée</span>
                        @else
                            <span class="badge-premium">{{ ucfirst($compensation['statut']) }}</span>
                        @endif
                    </td>
                    <td>{{ $compensation['date'] }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            @if($compensation['statut'] == 'en_attente')
                                <!-- Valider -->
                                <form action="{{ route('comptable.valider', $compensation['id']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-custom btn-custom-primary py-1.5 px-2.5" title="Valider la compensation">
                                        <i class="fas fa-check m-0"></i>
                                    </button>
                                </form>
                                <!-- Payer -->
                                <form action="{{ route('comptable.payer', $compensation['id']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-custom btn-custom-success py-1.5 px-2.5" title="Marquer comme payée">
                                        <i class="fas fa-dollar-sign m-0"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small fw-bold">Traitée</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-scale-unbalanced d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucune compensation à traiter pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
