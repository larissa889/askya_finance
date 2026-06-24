@extends('layouts.dashboard')

@section('title', "Fiche d'arrêt")

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div class="page-title">
        <h1>Fiche d'arrêt</h1>
        <p>Arrêt de caisse de la journée | {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('caissier.end-of-day.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')]) }}" 
           class="btn-custom">
            <i class="fas fa-chevron-left"></i> Jour précédent
        </a>
        @if($date != \Carbon\Carbon::today()->format('Y-m-d'))
        <a href="{{ route('caissier.end-of-day.index', ['date' => \Carbon\Carbon::today()->format('Y-m-d')]) }}" 
           class="btn-custom btn-custom-primary">
            <i class="fas fa-calendar-day"></i> Aujourd'hui
        </a>
        @endif
    </div>
</div>

<form id="endOfDayForm" action="{{ route('caissier.end-of-day.store') }}" method="POST">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="cash_register_id" value="{{ $cashRegister->id }}">
    <input type="hidden" name="approvisionnement_compte" value="{{ $approvisionnementCompte }}">
    <input type="hidden" name="paiements_compte" value="{{ $paiementsCompte }}">
    <input type="hidden" name="depots_clients_compte" value="{{ $depotsClientsCompte }}">
    <input type="hidden" name="sorties_compte" value="{{ $sortiesCompte }}">
    
    <input type="hidden" name="solde_initial_caisse" value="{{ $soldeInitialCaisse }}">
    <input type="hidden" name="approvisionnement_caisse" value="{{ $approvisionnementCaisse }}">
    <input type="hidden" name="depots_clients_caisse" value="{{ $depotsClientsCaisse }}">
    <input type="hidden" name="paiements_caisse" value="{{ $paiementsCaisse }}">
    <input type="hidden" name="sorties_caisse" value="{{ $sortiesCaisse }}">
    <input type="hidden" name="nombre_transactions" value="{{ $nombreTransactions }}">

    <div class="row g-4 mb-5">
        <!-- Situation Compte -->
        <div class="col-lg-6">
            <div class="glass-card h-100">
                <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                    <i class="fas fa-file-invoice text-primary fs-5"></i>
                    <span>Situation Compte</span>
                </h4>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Solde initial</span>
                        <span class="fw-bold text-white">{{ number_format($soldeInitialCompte, 0, ',', ' ') }} FCFA</span>
                        <input type="hidden" name="solde_initial_compte" value="{{ $soldeInitialCompte }}">
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Approvisionnement</span>
                        <span class="fw-bold text-white">{{ number_format($approvisionnementCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Paiements</span>
                        <span class="fw-bold text-danger">-{{ number_format($paiementsCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Dépôts clients</span>
                        <span class="fw-bold text-success">+{{ number_format($depotsClientsCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Sorties</span>
                        <span class="fw-bold text-danger">-{{ number_format($sortiesCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(59, 130, 246, 0.03); border: 1px solid rgba(59, 130, 246, 0.15);">
                        <span class="text-white fw-bold">Solde final théorique</span>
                        <span class="fw-bold text-primary">{{ number_format($soldeFinalCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-white fw-bold">Solde final réel</span>
                        <input type="number" class="form-control form-control-custom text-end py-1.5" style="width: 180px;" 
                               name="solde_final_compte" value="{{ $history ? $history->solde_final_compte : $soldeFinalCompte }}" 
                               onchange="calculerEcartCompte()" oninput="calculerEcartCompte()">
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Écart</span>
                        <span class="fw-bold" id="ecartCompteValue" style="color: @if($ecartCompte === 0) #34d399 @else #f87171 @endif">{{ number_format($ecartCompte, 0, ',', ' ') }} FCFA</span>
                        <input type="hidden" name="ecart_compte" id="ecartCompteInput" value="{{ $ecartCompte }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Situation Caisse -->
        <div class="col-lg-6">
            <div class="glass-card h-100">
                <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                    <i class="fas fa-cash-register text-primary fs-5"></i>
                    <span>Situation Caisse</span>
                </h4>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Solde initial</span>
                        <span class="fw-bold text-white">{{ number_format($soldeInitialCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Approvisionnement</span>
                        <span class="fw-bold text-white">{{ number_format($approvisionnementCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Dépôts clients</span>
                        <span class="fw-bold text-success">+{{ number_format($depotsClientsCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Paiements</span>
                        <span class="fw-bold text-danger">-{{ number_format($paiementsCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Sorties</span>
                        <span class="fw-bold text-danger">-{{ number_format($sortiesCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(59, 130, 246, 0.03); border: 1px solid rgba(59, 130, 246, 0.15);">
                        <span class="text-white fw-bold">Solde final théorique</span>
                        <span class="fw-bold text-primary">{{ number_format($soldeFinalCaisse, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-white fw-bold">Solde final réel</span>
                        <input type="number" class="form-control form-control-custom text-end py-1.5" style="width: 180px;" 
                               name="solde_final_caisse" value="{{ $history ? $history->solde_final_caisse : $soldeFinalCaisse }}" 
                               onchange="calculerEcartCaisse()" oninput="calculerEcartCaisse()">
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
                        <span class="text-muted fw-bold">Écart de caisse</span>
                        <span class="fw-bold" id="ecartCaisseValue" style="color: @if($ecartCaisse === 0) #34d399 @else #f87171 @endif">{{ number_format($ecartCaisse, 0, ',', ' ') }} FCFA</span>
                        <input type="hidden" name="ecart_caisse" id="ecartCaisseInput" value="{{ $ecartCaisse }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-center mb-5">
        <button type="submit" class="btn-custom btn-custom-primary py-3 px-5 fs-6">
            <i class="fas fa-save"></i> Enregistrer la fiche d'arrêt
        </button>
    </div>
</form>

<!-- Transactions of the day Section -->
<div class="glass-card">
    <h3 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-list-check text-primary fs-5"></i>
        <span>Transactions du jour</span>
    </h3>
    
    @if($transactions->count() > 0)
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Service</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Heure</th>
                    <th>Reçu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->reference }}</strong></td>
                    <td>{{ $transaction->service ? $transaction->service->name : 'N/A' }}</td>
                    <td>{{ $transaction->client_name }}</td>
                    <td>
                        @if($transaction->type === 'encaissement')
                            <span class="text-success fw-semibold"><i class="fas fa-arrow-trend-down me-1"></i> {{ ucfirst($transaction->type) }}</span>
                        @else
                            <span class="text-danger fw-semibold"><i class="fas fa-arrow-trend-up me-1"></i> {{ ucfirst($transaction->type) }}</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $transaction->transaction_date ? $transaction->transaction_date->format('H:i') : $transaction->created_at->format('H:i') }}</td>
                    <td>
                        @if($transaction->receipt_path)
                        <div class="d-flex gap-2">
                            <a href="{{ asset($transaction->receipt_path) }}" target="_blank" class="btn-custom py-1 px-2.5" title="Voir le reçu">
                                <i class="fas fa-eye m-0"></i>
                            </a>
                            <a href="{{ asset($transaction->receipt_path) }}" download class="btn-custom py-1 px-2.5" title="Télécharger le reçu">
                                <i class="fas fa-download m-0"></i>
                            </a>
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="fas fa-folder-open d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
        Aucune transaction pour cette date.
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Solde final théorique
    const soldeFinalCompteTheorique = {{ $soldeFinalCompte }};
    const soldeFinalCaisseTheorique = {{ $soldeFinalCaisse }};

    function calculerEcartCompte() {
        const soldeReel = parseFloat(document.querySelector('input[name="solde_final_compte"]').value) || 0;
        const ecart = soldeReel - soldeFinalCompteTheorique;
        const valueSpan = document.getElementById('ecartCompteValue');
        
        valueSpan.textContent = ecart.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('ecartCompteInput').value = ecart;
        
        if (ecart === 0) {
            valueSpan.style.color = '#34d399';
        } else {
            valueSpan.style.color = '#f87171';
        }
    }

    function calculerEcartCaisse() {
        const soldeReel = parseFloat(document.querySelector('input[name="solde_final_caisse"]').value) || 0;
        const ecart = soldeReel - soldeFinalCaisseTheorique;
        const valueSpan = document.getElementById('ecartCaisseValue');
        
        valueSpan.textContent = ecart.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('ecartCaisseInput').value = ecart;
        
        if (ecart === 0) {
            valueSpan.style.color = '#34d399';
        } else {
            valueSpan.style.color = '#f87171';
        }
    }
</script>
@endsection
