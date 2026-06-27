@extends('layouts.dashboard')

@section('title', 'Gestion des Caissiers')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Gestion des Caissiers</h1>
        <p>Supervisez les caissiers de votre agence et accédez à leur historique d'activités.</p>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Caisse Assignée</th>
                    <th>Solde Caisse</th>
                    <th>État</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cashiers as $cashier)
                @php
                    $reg = $cashier->cashRegisters->first();
                @endphp
                <tr>
                    <td><strong>{{ $cashier->name }}</strong></td>
                    <td>{{ $cashier->email }}</td>
                    <td>{{ $cashier->phone ?? 'N/A' }}</td>
                    <td>{{ $reg ? $reg->name : 'Aucune' }}</td>
                    <td class="fw-bold text-white">{{ $reg ? number_format($reg->balance, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                    <td>
                        @if($reg && $reg->status === 'open')
                            <span class="badge-premium badge-premium-success">Ouverte</span>
                        @else
                            <span class="badge-premium">Fermée</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('superviseur.cashiers.activity', $cashier->id) }}" class="btn-custom py-1.5 px-3">
                            <i class="fas fa-chart-line me-1"></i> Activité
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun caissier enregistré dans votre agence.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
