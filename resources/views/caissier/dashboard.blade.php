@extends('layouts.dashboard')

@section('title', 'Tableau de Bord - Caissier')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Bonjour, {{ $caissier['nom'] }}</h1>
        <p>Bienvenue sur votre espace de travail. | {{ date('d/m/Y') }}</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-arrows-rotate"></i>
            </div>
            <div>
                <h3>{{ $statistiques['transactions_jour'] }}</h3>
                <p>Transactions du jour</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['montant_encaisse'], 0, ',', ' ') }} FCFA</h3>
                <p>Montant encaissé</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium warning">
            <div class="icon-box">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <h3>{{ $statistiques['transactions_attente'] }}</h3>
                <p>En attente</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-circle-xmark"></i>
            </div>
            <div>
                <h3>{{ $statistiques['transactions_annulees'] }}</h3>
                <p>Annulées</p>
            </div>
        </div>
    </div>
</div>

<!-- Services disponibles Section -->
<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-cubes text-primary fs-5"></i>
        <span>Services disponibles - {{ $caissier['agence'] }}</span>
    </h4>
    <div class="row g-4">
        @foreach($services as $service)
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('caissier.service.show', $service->code) }}" class="text-decoration-none d-block h-100">
                <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center transition" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.04);">
                    <div class="service-logo-wrapper mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%; background: #ffffff; padding: 10px; border: 2px solid rgba(255,255,255,0.1); box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                        @if($service->code === 'WIZ')
                            <img src="{{ asset('images/logos/wizall money.png') }}" alt="Wizall Money" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'COR')
                            <img src="{{ asset('images/logos/coris money.png') }}" alt="Coris Money" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'OM')
                            <img src="{{ asset('images/logos/orange money.png') }}" alt="Orange Money" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'MM')
                            <img src="{{ asset('images/logos/moov money.png') }}" alt="Moov Money" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'TM')
                            <img src="{{ asset('images/logos/telecel money.png') }}" alt="Telecel Money" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'WU')
                            <img src="{{ asset('images/logos/western union.png') }}" alt="Western Union" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'RIA')
                            <img src="{{ asset('images/logos/RIA.png') }}" alt="RIA" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'MGNK')
                            <img src="{{ asset('images/logos/moneyGram.png') }}" alt="MoneyGram NK" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @elseif($service->code === 'WUNK')
                            <img src="{{ asset('images/logos/western union.png') }}" alt="Western Union NK" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @else
                            <i class="fas fa-money-bill-transfer text-primary" style="font-size: 2.2rem;"></i>
                        @endif
                    </div>
                    <h5 class="fw-bold text-white mb-2">{{ $service->name }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.4;">{{ $service->description }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- Transactions and Cash Register Status -->
<div class="row g-5">
    <!-- Transactions Table -->
    <div class="col-xl-8">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-history text-primary fs-5"></i>
                <span>Dernières transactions</span>
            </h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction['reference'] }}</strong></td>
                            <td>{{ $transaction['client'] }}</td>
                            <td class="fw-bold">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($transaction['type'] === 'encaissement')
                                    <span class="text-success"><i class="fas fa-arrow-trend-down me-1"></i> Entrée</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-arrow-trend-up me-1"></i> Sortie</span>
                                @endif
                            </td>
                            <td>{{ $transaction['date'] }}</td>
                            <td>
                                @if($transaction['statut'] == 'validée')
                                    <span class="badge-premium badge-premium-success">Validée</span>
                                @elseif($transaction['statut'] == 'en_attente')
                                    <span class="badge-premium badge-premium-warning">En attente</span>
                                @else
                                    <span class="badge-premium badge-premium-danger">Annulée</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Aucune transaction récente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cash Balance Summary -->
    <div class="col-xl-4">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-cash-register text-primary fs-5"></i>
                <span>Résumé de caisse</span>
            </h4>
            
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.03);">
                    <span class="text-muted fw-bold">Ouverture</span>
                    <span class="fw-bold text-white">{{ number_format($caisse['ouverture'], 0, ',', ' ') }} FCFA</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(16, 185, 129, 0.04); border: 1px solid rgba(16, 185, 129, 0.08);">
                    <span class="text-muted fw-bold">Encaissements</span>
                    <span class="fw-bold text-success">+{{ number_format($caisse['encaissements'], 0, ',', ' ') }} FCFA</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(239, 68, 68, 0.04); border: 1px solid rgba(239, 68, 68, 0.08);">
                    <span class="text-muted fw-bold">Décaissements</span>
                    <span class="fw-bold text-danger">-{{ number_format($caisse['decaissements'], 0, ',', ' ') }} FCFA</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-4 rounded-4 mt-2" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%); border: 1px solid rgba(59, 130, 246, 0.15);">
                    <span class="text-white fw-bold fs-6">Solde actuel</span>
                    <span class="fw-extrabold text-primary fs-5">{{ number_format($caisse['solde'], 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications Section -->
<div class="glass-card mt-5">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-bell text-primary fs-5"></i>
        <span>Notifications récentes</span>
    </h4>
    <div class="d-flex flex-column gap-3">
        @forelse($notifications as $notification)
            <div class="d-flex align-items-start gap-3 p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04);">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0; background: 
                    @if($notification['type'] === 'success') rgba(16, 185, 129, 0.1) @elseif($notification['type'] === 'danger') rgba(239, 68, 68, 0.1) @else rgba(245, 158, 11, 0.1) @endif; color:
                    @if($notification['type'] === 'success') #34d399 @elseif($notification['type'] === 'danger') #f87171 @else #fbbf24 @endif;">
                    
                    @if($notification['type'] === 'success')
                        <i class="fas fa-circle-check"></i>
                    @elseif($notification['type'] === 'danger')
                        <i class="fas fa-circle-xmark"></i>
                    @else
                        <i class="fas fa-triangle-exclamation"></i>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <p class="mb-1 text-white fw-semibold">{{ $notification['message'] }}</p>
                    <small class="text-muted">{{ $notification['heure'] }}</small>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">Aucune nouvelle notification.</p>
        @endforelse
    </div>
</div>
@endsection
