@extends('layouts.dashboard')

@section('title', 'Gestion des Caisses')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="page-title">
        <h1>Gestion des Caisses</h1>
        <p>Gérez les caisses physiques des caissiers, les caisses principales d'agences et les comptes bancaires.</p>
    </div>
    <a href="{{ route('admin.registers.create') }}" class="btn-custom btn-custom-primary">
        <i class="fas fa-plus"></i> Nouvelle Caisse
    </a>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Agence</th>
                    <th>Détenteur / Banque</th>
                    <th>Solde Actuel</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registers as $register)
                <tr>
                    <td><strong>{{ $register->code }}</strong></td>
                    <td>{{ $register->name }}</td>
                    <td>
                        @if($register->type === 'main')
                            <span class="badge-premium badge-premium-danger">Caisse Principale</span>
                        @elseif($register->type === 'bank')
                            <span class="badge-premium badge-premium-warning">Compte Bancaire</span>
                        @else
                            <span class="badge-premium badge-premium-info">Caisse Caissier</span>
                        @endif
                    </td>
                    <td>{{ $register->agency ? $register->agency->name : 'N/A' }}</td>
                    <td>
                        @if($register->type === 'bank')
                            <span class="fw-bold text-white"><i class="fas fa-university me-1"></i>{{ $register->bank ? $register->bank->name : 'N/A' }}</span>
                        @else
                            {{ $register->assignedTo ? $register->assignedTo->name : 'Non assignée' }}
                        @endif
                    </td>
                    <td class="fw-bold text-white">{{ number_format($register->balance, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($register->status === 'open')
                            <span class="badge-premium badge-premium-success">Ouverte</span>
                        @else
                            <span class="badge-premium text-muted">Fermée</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.registers.show', $register) }}" class="btn-custom py-1.5 px-2.5" title="Consulter l'historique">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <a href="{{ route('admin.registers.edit', $register) }}" class="btn-custom py-1.5 px-2.5" title="Modifier">
                                <i class="fas fa-edit m-0"></i>
                            </a>
                            <form action="{{ route('admin.registers.destroy', $register) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette caisse ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-custom-danger py-1.5 px-2.5" title="Supprimer">
                                    <i class="fas fa-trash m-0"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Aucune caisse configurée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
