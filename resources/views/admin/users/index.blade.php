@extends('layouts.dashboard')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="page-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="page-title">
            <h1><i class="fas fa-users me-2 text-primary"></i>Gestion des utilisateurs</h1>
            <p>Gérez tous les comptes d'utilisateurs de la plateforme (création, modification, rôles et accès).</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn-custom btn-custom-primary py-2.5 px-4">
                <i class="fas fa-plus"></i> Ajouter un utilisateur
            </a>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role && $user->role->value === 'admin')
                            <span class="badge-premium badge-premium-danger">Admin</span>
                        @elseif($user->role && $user->role->value === 'superviseur')
                            <span class="badge-premium badge-premium-warning">Superviseur</span>
                        @elseif($user->role && $user->role->value === 'comptable')
                            <span class="badge-premium badge-premium-success">Comptable</span>
                        @elseif($user->role && $user->role->value === 'caissier')
                            <span class="badge-premium badge-premium-info">Caissier</span>
                        @else
                            <span class="badge-premium">{{ $user->role ? ucfirst($user->role->value) : '-' }}</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-custom py-1.5 px-2.5" title="Détails">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-custom py-1.5 px-2.5" title="Modifier">
                                <i class="fas fa-edit m-0"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
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
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fas fa-users d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                        Aucun utilisateur trouvé sur la plateforme.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

