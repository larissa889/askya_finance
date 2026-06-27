@extends('layouts.dashboard')

@section('title', 'Validation des Approvisionnements')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Validation des Approvisionnements</h1>
        <p>Validez ou rejetez les demandes d'approvisionnement et de reversement de votre agence.</p>
    </div>
</div>

<div class="glass-card">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-hourglass-half text-primary me-2"></i>Demandes en attente</h4>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Caissier</th>
                    <th>Type</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Montant</th>
                    <th>Date demande</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingSupplies as $supply)
                <tr>
                    <td><strong>{{ $supply->reference }}</strong></td>
                    <td>{{ $supply->createdBy->name }}</td>
                    <td>
                        @if($supply->type === 'client')
                            <span class="badge-premium badge-premium-info">Client</span>
                        @elseif($supply->type === 'product')
                            <span class="badge-premium badge-premium-warning">Inter-Produits</span>
                        @elseif($supply->type === 'agency')
                            <span class="badge-premium badge-premium-danger">Inter-Agences</span>
                        @else
                            <span class="badge-premium text-white" style="background: rgba(139, 92, 246, 0.15); border-color: rgba(139, 92, 246, 0.3);">Reversement</span>
                        @endif
                    </td>
                    <td>
                        @if($supply->type === 'product')
                            {{ $supply->serviceSource ? $supply->serviceSource->name : 'N/A' }}
                        @elseif($supply->type === 'agency')
                            {{ $supply->agencySource ? $supply->agencySource->name : 'N/A' }}
                        @elseif($supply->type === 'central')
                            {{ $supply->cashRegisterSource ? $supply->cashRegisterSource->name : 'Caisse Caissier' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($supply->type === 'product')
                            {{ $supply->serviceDestination ? $supply->serviceDestination->name : 'N/A' }}
                        @else
                            {{ $supply->cashRegisterDestination ? $supply->cashRegisterDestination->name : 'Caisse' }}
                        @endif
                    </td>
                    <td class="fw-bold text-white">{{ number_format($supply->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $supply->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Approve -->
                            <form action="{{ route('superviseur.supplies.valider', $supply->id) }}" method="POST" onsubmit="return confirm('Voulez-vous approuver cette demande d\'approvisionnement ?')">
                                @csrf
                                <button type="submit" class="btn-custom btn-custom-success py-1.5 px-2.5" title="Approuver">
                                    <i class="fas fa-check m-0"></i> Approuver
                                </button>
                            </form>
                            
                            <!-- Reject Button triggers modal -->
                            <button type="button" class="btn-custom btn-custom-danger py-1.5 px-2.5" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $supply->id }}">
                                <i class="fas fa-times m-0"></i> Rejeter
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal{{ $supply->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-content-custom">
                            <form action="{{ route('superviseur.supplies.rejeter', $supply->id) }}" method="POST">
                                @csrf
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold text-white">Rejeter la demande {{ $supply->reference }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body modal-body-custom">
                                    <div class="mb-3">
                                        <label for="rejection_reason{{ $supply->id }}" class="form-label-custom">Motif du rejet *</label>
                                        <input type="text" class="form-control form-control-custom" id="rejection_reason{{ $supply->id }}" name="rejection_reason" required placeholder="Ex: Solde insuffisant, motif non justifié...">
                                    </div>
                                </div>
                                <div class="modal-footer modal-footer-custom">
                                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn-custom btn-custom-danger">Rejeter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Aucune demande en attente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
