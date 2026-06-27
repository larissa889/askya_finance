@extends('layouts.dashboard')

@section('title', 'Clôtures Journalières')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Clôtures Journalières (Fiches d'arrêt)</h1>
        <p>Vérifiez et validez les clôtures journalières de caisse soumises par les caissiers.</p>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Caissier</th>
                    <th>Agence</th>
                    <th>Caisse</th>
                    <th>Transactions</th>
                    <th>Écart Caisse</th>
                    <th>Solde Réel Caisse</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr>
                    <td><strong>{{ $history->date->format('d/m/Y') }}</strong></td>
                    <td>{{ $history->createdBy->name }}</td>
                    <td>{{ $history->agency ? $history->agency->name : 'N/A' }}</td>
                    <td>{{ $history->cashRegister ? $history->cashRegister->name : 'N/A' }}</td>
                    <td><span class="badge-premium badge-premium-info">{{ $history->nombre_transactions }}</span></td>
                    <td class="fw-bold {{ $history->ecart_caisse == 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($history->ecart_caisse, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="fw-bold text-white">{{ number_format($history->solde_final_caisse, 0, ',', ' ') }} FCFA</td>
                    <td class="small text-muted">{{ $history->notes ?? 'Aucune note' }}</td>
                    <td>
                        @if(strpos($history->notes ?? '', 'Validé par le comptable') !== false)
                            <span class="text-success fw-bold small"><i class="fas fa-check-double me-1"></i> Validée</span>
                        @else
                            <form action="{{ route('comptable.closures.valider', $history->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous la validation de cette clôture journalière ?')">
                                @csrf
                                <button type="submit" class="btn-custom btn-custom-success py-1.5 px-3">
                                    <i class="fas fa-check me-1"></i> Valider
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">Aucune clôture journalière soumise pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
