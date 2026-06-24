@extends('layouts.dashboard')

@section('title', 'Recherche de Transactions')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Recherche</h1>
        <p>Recherchez des transactions, des clients ou des références d'opérations</p>
    </div>
</div>

<!-- Search Input Card -->
<div class="glass-card mb-4" style="max-width: 900px;">
    <form action="{{ route('caissier.search.index') }}" method="GET">
        <div class="d-flex flex-column flex-md-row gap-3">
            <div class="flex-grow-1 position-relative">
                <input type="text" class="form-control-custom" name="query" value="{{ $query ?? '' }}" placeholder="Entrez une référence, un nom de client ou un numéro..." required style="padding-left: 45px !important;">
                <i class="fas fa-search position-absolute text-muted" style="left: 18px; top: 50%; transform: translateY(-50%); font-size: 1.1rem;"></i>
            </div>
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <span>Rechercher</span>
            </button>
        </div>
    </form>
</div>

<!-- Results Card -->
@if(isset($query) && $query)
    <div class="glass-card" style="max-width: 900px;">
        <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
            <i class="fas fa-list-ul text-primary fs-5"></i>
            <span>Résultats pour "{{ $query }}"</span>
        </h4>
        
        @if(!empty($results))
            <div class="d-flex flex-column gap-3">
                @foreach($results as $result)
                <div class="p-4 rounded-4 transition" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='var(--border-glass)'">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold text-primary" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            @if($result['type'] === 'transaction')
                                <i class="fas fa-exchange-alt me-1"></i> Transaction
                            @else
                                <i class="fas fa-user me-1"></i> Client
                            @endif
                        </span>
                        
                        <span class="badge-premium @if($result['type'] === 'transaction') badge-premium-info @else badge-premium-success @endif">
                            {{ ucfirst($result['type']) }}
                        </span>
                    </div>
                    
                    @if($result['type'] == 'transaction')
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">Référence</span>
                            <span class="text-white fw-bold">{{ $result['reference'] }}</span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">Client</span>
                            <span class="text-white">{{ $result['client'] }}</span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">Montant</span>
                            <span class="text-white fw-extrabold text-success">{{ number_format($result['montant'], 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                    @else
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">Nom</span>
                            <span class="text-white fw-bold">{{ $result['nom'] }}</span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">Téléphone</span>
                            <span class="text-white">{{ $result['telephone'] }}</span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="text-muted d-block small fw-bold text-uppercase">E-mail</span>
                            <span class="text-white">{{ $result['email'] }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-folder-open d-block mb-3 fs-3 text-muted" style="opacity: 0.5;"></i>
                Aucun résultat trouvé pour "{{ $query }}". Veuillez affiner vos critères de recherche.
            </div>
        @endif
    </div>
@endif
@endsection
