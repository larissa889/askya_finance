@extends('layouts.dashboard')

@section('title', 'Gestion des Services Financiers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="page-title">
        <h1>Gestion des Produits Financiers</h1>
        <p>Gérez les comptes de Mobile Money, monnaies électroniques et Africards.</p>
    </div>
    <button type="button" class="btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#createServiceModal">
        <i class="fas fa-plus"></i> Nouveau Produit
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td><span class="badge-premium badge-premium-info">{{ $service->code }}</span></td>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>{{ $service->description ?? 'Aucune description' }}</td>
                    <td>
                        @if($service->is_active)
                            <span class="badge-premium badge-premium-success">Actif</span>
                        @else
                            <span class="badge-premium text-muted">Désactivé</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.services.show', $service) }}" class="btn-custom py-1.5 px-2.5" title="Configurer les agences">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <button type="button" class="btn-custom py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}" title="Modifier">
                                <i class="fas fa-edit m-0"></i>
                            </button>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-custom-danger py-1.5 px-2.5" title="Supprimer">
                                    <i class="fas fa-trash m-0"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Modifier Produit -->
                <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-content-custom">
                            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold text-white">Modifier le produit {{ $service->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                                    <div>
                                        <label for="name{{ $service->id }}" class="form-label-custom">Nom du produit *</label>
                                        <input type="text" class="form-control form-control-custom" id="name{{ $service->id }}" name="name" required value="{{ $service->name }}">
                                    </div>
                                    <div>
                                        <label for="code{{ $service->id }}" class="form-label-custom">Code du produit *</label>
                                        <input type="text" class="form-control form-control-custom" id="code{{ $service->id }}" name="code" required value="{{ $service->code }}">
                                    </div>
                                    <div>
                                        <label for="description{{ $service->id }}" class="form-label-custom">Description</label>
                                        <textarea class="form-control form-control-custom" id="description{{ $service->id }}" name="description" rows="3">{{ $service->description }}</textarea>
                                    </div>
                                    <div>
                                        <label for="is_active{{ $service->id }}" class="form-label-custom">Statut</label>
                                        <select class="form-control form-control-custom form-select-custom" id="is_active{{ $service->id }}" name="is_active" required>
                                            <option value="1" {{ $service->is_active ? 'selected' : '' }}>Actif</option>
                                            <option value="0" {{ !$service->is_active ? 'selected' : '' }}>Désactivé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer modal-footer-custom">
                                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn-custom btn-custom-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucun service enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Créer Produit -->
<div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white" id="createServiceModalLabel">Ajouter un nouveau produit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                    <div>
                        <label for="name" class="form-label-custom">Nom du produit *</label>
                        <input type="text" class="form-control form-control-custom" id="name" name="name" required placeholder="Ex: Orange Money">
                    </div>
                    <div>
                        <label for="code" class="form-label-custom">Code du produit *</label>
                        <input type="text" class="form-control form-control-custom" id="code" name="code" required placeholder="Ex: OM">
                    </div>
                    <div>
                        <label for="description" class="form-label-custom">Description</label>
                        <textarea class="form-control form-control-custom" id="description" name="description" rows="3" placeholder="Description du produit..."></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-custom btn-custom-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
