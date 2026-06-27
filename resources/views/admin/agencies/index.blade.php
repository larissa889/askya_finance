@extends('layouts.dashboard')

@section('title', 'Gestion des Agences')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="page-title">
        <h1>Gestion des Agences</h1>
        <p>Consultez, ajoutez et configurez les agences d'Askya Finance.</p>
    </div>
    <button type="button" class="btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#createAgencyModal">
        <i class="fas fa-plus"></i> Nouvelle Agence
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Responsable</th>
                    <th>Téléphone</th>
                    <th>Encaisse Physique</th>
                    <th>Solde Électronique</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agencies as $agency)
                <tr>
                    <td><span class="badge-premium badge-premium-info">{{ $agency->code }}</span></td>
                    <td><strong>{{ $agency->name }}</strong></td>
                    <td>{{ $agency->manager ?? 'N/A' }}</td>
                    <td>{{ $agency->phone ?? 'N/A' }}</td>
                    <td class="fw-bold text-white">{{ number_format($agency->cash_balance, 0, ',', ' ') }} FCFA</td>
                    <td class="fw-bold text-white">{{ number_format($agency->electronic_balance, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($agency->is_active)
                            <span class="badge-premium badge-premium-success">Active</span>
                        @else
                            <span class="badge-premium">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.agencies.show', $agency) }}" class="btn-custom py-1.5 px-2.5" title="Consulter les utilisateurs">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <button type="button" class="btn-custom py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#editAgencyModal{{ $agency->id }}" title="Modifier">
                                <i class="fas fa-edit m-0"></i>
                            </button>
                            <form action="{{ route('admin.agencies.destroy', $agency) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-custom-danger py-1.5 px-2.5" title="Supprimer">
                                    <i class="fas fa-trash m-0"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Modifier Agence -->
                <div class="modal fade" id="editAgencyModal{{ $agency->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-content-custom">
                            <form action="{{ route('admin.agencies.update', $agency) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold text-white">Modifier l'agence {{ $agency->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                                    <div>
                                        <label for="name{{ $agency->id }}" class="form-label-custom">Nom de l'agence *</label>
                                        <input type="text" class="form-control form-control-custom" id="name{{ $agency->id }}" name="name" required value="{{ $agency->name }}">
                                    </div>
                                    <div>
                                        <label for="code{{ $agency->id }}" class="form-label-custom">Code de l'agence *</label>
                                        <input type="text" class="form-control form-control-custom" id="code{{ $agency->id }}" name="code" required maxlength="10" value="{{ $agency->code }}">
                                    </div>
                                    <div>
                                        <label for="manager{{ $agency->id }}" class="form-label-custom">Responsable / Manager</label>
                                        <input type="text" class="form-control form-control-custom" id="manager{{ $agency->id }}" name="manager" value="{{ $agency->manager }}">
                                    </div>
                                    <div>
                                        <label for="phone{{ $agency->id }}" class="form-label-custom">Téléphone</label>
                                        <input type="text" class="form-control form-control-custom" id="phone{{ $agency->id }}" name="phone" value="{{ $agency->phone }}">
                                    </div>
                                    <div>
                                        <label for="email{{ $agency->id }}" class="form-label-custom">Email</label>
                                        <input type="email" class="form-control form-control-custom" id="email{{ $agency->id }}" name="email" value="{{ $agency->email }}">
                                    </div>
                                    <div>
                                        <label for="address{{ $agency->id }}" class="form-label-custom">Adresse</label>
                                        <input type="text" class="form-control form-control-custom" id="address{{ $agency->id }}" name="address" value="{{ $agency->address }}">
                                    </div>
                                    <div>
                                        <label for="is_active{{ $agency->id }}" class="form-label-custom">Statut</label>
                                        <select class="form-control form-control-custom form-select-custom" id="is_active{{ $agency->id }}" name="is_active" required>
                                            <option value="1" {{ $agency->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$agency->is_active ? 'selected' : '' }}>Inactive</option>
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
                    <td colspan="8" class="text-center text-muted py-4">Aucune agence enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Créer Agence -->
<div class="modal fade" id="createAgencyModal" tabindex="-1" aria-labelledby="createAgencyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="{{ route('admin.agencies.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-white" id="createAgencyModalLabel">Ajouter une nouvelle agence</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-custom d-flex flex-column gap-3">
                    <div>
                        <label for="name" class="form-label-custom">Nom de l'agence *</label>
                        <input type="text" class="form-control form-control-custom" id="name" name="name" required placeholder="Ex: Somgandé">
                    </div>
                    <div>
                        <label for="code" class="form-label-custom">Code de l'agence *</label>
                        <input type="text" class="form-control form-control-custom" id="code" name="code" required maxlength="10" placeholder="Ex: SOM">
                    </div>
                    <div>
                        <label for="manager" class="form-label-custom">Responsable / Manager</label>
                        <input type="text" class="form-control form-control-custom" id="manager" name="manager" placeholder="Nom du responsable">
                    </div>
                    <div>
                        <label for="phone" class="form-label-custom">Téléphone</label>
                        <input type="text" class="form-control form-control-custom" id="phone" name="phone" placeholder="+226 70 00 00 00">
                    </div>
                    <div>
                        <label for="email" class="form-label-custom">Email</label>
                        <input type="email" class="form-control form-control-custom" id="email" name="email" placeholder="contact@somgande.com">
                    </div>
                    <div>
                        <label for="address" class="form-label-custom">Adresse</label>
                        <input type="text" class="form-control form-control-custom" id="address" name="address" placeholder="Secteur 25, Somgandé">
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
