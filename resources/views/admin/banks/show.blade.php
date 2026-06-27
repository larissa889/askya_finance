@extends('layouts.dashboard')

@section('title', 'Détails de la Banque')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.banks.index') }}" class="text-primary text-decoration-none">Banques</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $bank->name }}</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Banque {{ $bank->name }}</h1>
            <p>Code: <strong>{{ $bank->code }}</strong></p>
        </div>
        <a href="{{ route('admin.banks.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-cash-register text-primary me-2"></i>Comptes / Caisses bancaires associés</h4>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code Caisse</th>
                    <th>Nom</th>
                    <th>Agence</th>
                    <th>Solde Actuel</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registers as $reg)
                <tr style="cursor: pointer;" onclick="window.location.href='{{ route('admin.registers.show', $reg) }}'">
                    <td><strong>{{ $reg->code }}</strong></td>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->agency ? $reg->agency->name : 'N/A' }}</td>
                    <td class="fw-bold text-white">{{ number_format($reg->balance, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($reg->status === 'open')
                            <span class="badge-premium badge-premium-success">Ouverte</span>
                        @else
                            <span class="badge-premium">Fermée</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucune caisse bancaire associée à cette banque.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
