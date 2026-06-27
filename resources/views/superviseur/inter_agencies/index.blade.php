@extends('layouts.dashboard')

@section('title', 'Suivi Inter-Agences')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Suivi des Opérations Inter-Agences</h1>
        <p>Suivez les dettes générées par les transferts de fonds et approvisionnements entre agences.</p>
    </div>
</div>

<div class="row g-5">
    <!-- Debts to us -->
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-arrow-trend-down text-success me-2"></i>Dettes envers notre agence</h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Agence Debtrice</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($debtsToUs as $debt)
                        <tr>
                            <td><strong>{{ $debt->reference }}</strong></td>
                            <td>{{ $debt->agencyDestination ? $debt->agencyDestination->name : 'N/A' }}</td>
                            <td class="fw-bold text-success">+{{ number_format($debt->amount, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $debt->approved_at ? $debt->approved_at->format('d/m/Y') : $debt->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Aucune créance envers d'autres agences.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Debts we owe -->
    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-arrow-trend-up text-danger me-2"></i>Nos dettes envers d'autres agences</h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Agence Créancière</th>
                            <th>Montant</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($debtsWeOwe as $debt)
                        <tr>
                            <td><strong>{{ $debt->reference }}</strong></td>
                            <td>{{ $debt->agencySource ? $debt->agencySource->name : 'N/A' }}</td>
                            <td class="fw-bold text-danger">-{{ number_format($debt->amount, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $debt->approved_at ? $debt->approved_at->format('d/m/Y') : $debt->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Félicitations, vous n'avez aucune dette inter-agences.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
