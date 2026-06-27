@extends('layouts.dashboard')

@section('title', 'Gestion des Banques')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="page-title">
        <h1>Gestion des Banques</h1>
        <p>Gérez les établissements bancaires partenaires et associez des caisses.</p>
    </div>
    <button type="button" class="btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#createBankModal">
        <i class="fas fa-plus"></i> Nouvelle Banque
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                <tr>
                    <td><span class="badge-premium badge-premium-info">{{ $bank->code }}</span></td>
                    <td><strong>{{ $bank->name }}</strong></td>
                    <td>
                        @if($bank->is_active)
                            <span class="badge-premium badge-premium-success">Active</span>
                        @else
                            <span class="badge-premium text-muted">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.banks.show', $bank) }}" class="btn-custom py-1.5 px-2.5" title="Consulter">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <button type="button" class="btn-custom py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#editBankModal{{ $bank->id }}" title="Modifier">
                                <i class="fas fa-edit m-0"></i>
                            </button>
                            <form action="{{ route('admin.banks.destroy', $bank) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette banque ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-custom-danger py-1.5 px-2.5" title="Supprimer">
                                    <i class="fas fa-trash m-0"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Modifier Banque -->
                <div class="modal fade" id="editBankModal{{ $bank->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-content-custom">
                            <form action="{{ route('admin.banks.update', $bank) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold text-white">Modifier la banque {{ $bank->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                                    <div>
                                        <label for="name{{ $bank->id }}" class="form-label-custom">Nom de la banque *</label>
                                        <input type="text" class="form-control form-control-custom" id="name{{ $bank->id }}" name="name" required value="{{ $bank->name }}">
                                    </div>
                                    <div>
                                        <label for="code{{ $bank->id }}" class="form-label-custom">Code de la banque *</label>
                                        <input type="text" class="form-control form-control-custom" id="code{{ $bank->id }}" name="code" required value="{{ $bank->code }}">
                                    </div>
                                    <div>
                                        <label for="is_active{{ $bank->id }}" class="form-label-custom">Statut</label>
                                        <select class="form-control form-control-custom form-select-custom" id="is_active{{ $bank->id }}" name="is_active" required>
                                            <option value="1" {{ $bank->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$bank->is_active ? 'selected' : '' }}>Inactive</option>
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
                    <td colspan="4" class="text-center text-muted py-4">Aucune banque enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Créer Banque -->
<div class="modal fade" id="createBankModal" tabindex="-1" aria-labelledby="createBankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('admin.banks.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white" id="createBankModalLabel">Ajouter une nouvelle banque</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                    <div>
                        <label for="name" class="form-label-custom">Nom de la banque *</label>
                        <input type="text" class="form-control form-control-custom" id="name" name="name" required placeholder="Ex: Orabank">
                    </div>
                    <div>
                        <label for="code" class="form-label-custom">Code de la banque *</label>
                        <input type="text" class="form-control form-control-custom" id="code" name="code" required placeholder="Ex: ORA">
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
