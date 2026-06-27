@extends('layouts.dashboard')

@section('title', 'Résultats de Rapprochement')

@section('content')
<div class="page-header">
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Résultats du Rapprochement - {{ $bank->name }}</h1>
            <p>Revue des correspondances et des anomalies détectées avec le relevé bancaire.</p>
        </div>
        <a href="{{ route('comptable.reconciliation.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Nouveau Rapprochement
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <h3>{{ $matchedCount }}</h3>
                <p>Transactions Rapprochées (Exactes / Partielles)</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-circle-exclamation"></i>
            </div>
            <div>
                <h3>{{ $discrepancyCount }}</h3>
                <p>Écarts / Anomalies Détectés</p>
            </div>
        </div>
    </div>
</div>

<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-list text-primary me-2"></i>Lignes de Relevé Rapprochées</h4>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Relevé (Date/Ref/Montant)</th>
                    <th>Système Askya (Date/Ref/Montant)</th>
                    <th>Résultat</th>
                    <th>Observations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $res)
                <tr>
                    <td>
                        <div class="small fw-bold text-white">{{ $res['bank_record']['reference'] }}</div>
                        <div class="small text-muted">{{ $res['bank_record']['date'] }} | {{ number_format($res['bank_record']['amount'], 0, ',', ' ') }} FCFA</div>
                    </td>
                    <td>
                        @if($res['db_record'])
                            <div class="small fw-bold text-white">{{ $res['db_record']['reference'] }}</div>
                            <div class="small text-muted">{{ $res['db_record']['date'] }} | {{ number_format($res['db_record']['amount'], 0, ',', ' ') }} FCFA ({{ $res['db_record']['client'] }})</div>
                        @else
                            <span class="text-danger small fw-bold">Aucune transaction trouvée</span>
                        @endif
                    </td>
                    <td>
                        @if($res['status'] === 'matched')
                            <span class="badge-premium badge-premium-success">Correspondance</span>
                        @elseif($res['status'] === 'partial_matched')
                            <span class="badge-premium badge-premium-warning">Fuzzy Match</span>
                        @elseif($res['status'] === 'discrepancy')
                            <span class="badge-premium badge-premium-danger">Écart Montant</span>
                        @else
                            <span class="badge-premium badge-premium-danger">Manquant BD</span>
                        @endif
                    </td>
                    <td class="small text-white-50">{{ $res['notes'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="glass-card">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-triangle-exclamation text-warning me-2"></i>Transactions système non trouvées sur le relevé</h4>
    <p class="text-muted small">Ces transactions sont enregistrées comme validées dans le système, mais ne figurent pas sur le fichier de relevé bancaire fourni.</p>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Caissier</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unmatchedSystemTxs as $tx)
                <tr>
                    <td><strong>{{ $tx->reference }}</strong></td>
                    <td>{{ $tx->client_name }}</td>
                    <td class="fw-bold text-white">{{ number_format($tx->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $tx->created_at->format('d/m/Y') }}</td>
                    <td>{{ $tx->createdBy->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Toutes les transactions système figurent dans le relevé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
