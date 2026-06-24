@extends('layouts.dashboard')

@section('title', $service->name)

@section('content')
<div class="page-header">
    <a href="{{ route('caissier.dashboard') }}" class="btn-custom mb-4 text-decoration-none">
        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
    </a>
    
    <div class="glass-card p-4">
        <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start gap-4">
            <div class="service-logo-wrapper d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; border-radius: 50%; background: #ffffff; padding: 12px; border: 2.5px solid rgba(255,255,255,0.1); box-shadow: 0 4px 15px rgba(0,0,0,0.15); flex-shrink: 0;">
                @if($service->code === 'WIZ')
                    <img src="{{ asset('images/logos/wizall money.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'COR')
                    <img src="{{ asset('images/logos/coris money.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'OM')
                    <img src="{{ asset('images/logos/orange money.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'MM')
                    <img src="{{ asset('images/logos/moov money.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'TM')
                    <img src="{{ asset('images/logos/telecel money.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'WU')
                    <img src="{{ asset('images/logos/western union.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'RIA')
                    <img src="{{ asset('images/logos/RIA.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'MGNK')
                    <img src="{{ asset('images/logos/moneyGram.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @elseif($service->code === 'WUNK')
                    <img src="{{ asset('images/logos/western union.png') }}" alt="{{ $service->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @else
                    <i class="fas fa-money-bill-transfer text-primary" style="font-size: 2.5rem;"></i>
                @endif
            </div>
            <div>
                <h2 class="fw-bold text-white mb-2">{{ $service->name }}</h2>
                <p class="text-muted mb-0">{{ $service->description }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Operation Types Selection Grid -->
<div class="glass-card mt-5">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-cogs text-primary fs-5"></i>
        <span>Types d'opérations disponibles</span>
    </h4>
    
    <div class="row g-4">
        @foreach($operationTypes as $operationType)
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('caissier.transactions.create', ['service' => $service->code, 'operation_type' => $operationType->code]) }}" class="text-decoration-none d-block h-100">
                <div class="glass-card p-4 h-100 d-flex flex-column align-items-center text-center transition" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.04);">
                    <div class="icon-box-operation mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #60a5fa; font-size: 1.3rem; border: 1px solid rgba(59, 130, 246, 0.2);">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">{{ $operationType->name }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.4;">{{ $operationType->description }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
