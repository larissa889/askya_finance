@extends('layouts.dashboard')

@section('title', 'Détails Transaction')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('caissier.transactions.index') }}" class="text-primary text-decoration-none">Transactions</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $transaction->reference }}</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Détails de la transaction</h1>
        <p>Référence: <strong>{{ $transaction->reference }}</strong></p>
    </div>
</div>

<div class="glass-card" style="max-width: 900px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 gap-3" style="border-bottom: 1px solid var(--border-glass);">
        <div>
            <h2 class="fw-bold text-white mb-2">{{ $transaction->reference }}</h2>
            @if($transaction->status === 'recorded')
                <span class="badge-premium badge-premium-warning">Enregistrée</span>
            @elseif($transaction->status === 'reconciled')
                <span class="badge-premium badge-premium-success">Rapprochée</span>
            @elseif($transaction->status === 'discrepancy')
                <span class="badge-premium badge-premium-danger">En écart</span>
            @elseif($transaction->status === 'compensated')
                <span class="badge-premium badge-premium-info">Compensée</span>
            @else
                <span class="badge-premium">{{ ucfirst($transaction->status) }}</span>
            @endif
        </div>
        <div class="fs-2 fw-extrabold text-primary">
            {{ number_format($transaction->total, 0, ',', ' ') }} FCFA
        </div>
    </div>

    <div class="d-flex flex-column gap-3">
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Type de transaction</div>
            <div class="col-md-8 text-white fw-semibold">
                @if($transaction->type === 'encaissement')
                    <span class="text-success"><i class="fas fa-arrow-trend-down me-1"></i> {{ ucfirst($transaction->type) }}</span>
                @else
                    <span class="text-danger"><i class="fas fa-arrow-trend-up me-1"></i> {{ ucfirst($transaction->type) }}</span>
                @endif
            </div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Montant net</div>
            <div class="col-md-8 text-white">{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Frais de service</div>
            <div class="col-md-8 text-white">{{ number_format($transaction->fees, 0, ',', ' ') }} FCFA</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Total</div>
            <div class="col-md-8 text-primary fw-extrabold fs-5">{{ number_format($transaction->total, 0, ',', ' ') }} FCFA</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Nom du client</div>
            <div class="col-md-8 text-white fw-semibold">{{ $transaction->client_name }}</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Téléphone client</div>
            <div class="col-md-8 text-white">{{ $transaction->client_phone ?? '-' }}</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Service financier</div>
            <div class="col-md-8 text-white fw-semibold">{{ $transaction->service ? $transaction->service->name : 'N/A' }}</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Caissier opérationnel</div>
            <div class="col-md-8 text-white">{{ $transaction->createdBy ? $transaction->createdBy->name : 'N/A' }}</div>
        </div>
        
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Date d'opération</div>
            <div class="col-md-8 text-white">{{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y H:i') : $transaction->created_at->format('d/m/Y H:i') }}</div>
        </div>
        
        @if($transaction->notes)
        <div class="row py-3 g-2" style="border-bottom: 1px solid var(--border-glass);">
            <div class="col-md-4 fw-bold text-muted text-uppercase small">Notes / Justification</div>
            <div class="col-md-8 text-white" style="line-height: 1.5;">{{ $transaction->notes }}</div>
        </div>
        @endif
    </div>

    <!-- Receipt attachment display -->
    @if($transaction->receipt_path)
    <div class="p-4 rounded-4 mt-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-glass);">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-file-invoice text-primary fs-3"></i>
            <div>
                <h5 class="fw-bold text-white mb-1">Reçu de transaction attaché</h5>
                <p class="mb-0 text-muted small">Vous pouvez visualiser ou télécharger le document numérique.</p>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto">
            <a href="{{ asset($transaction->receipt_path) }}" target="_blank" class="btn-custom py-2.5 px-4 flex-fill justify-content-center">
                <i class="fas fa-eye"></i> Visualiser
            </a>
            <a href="{{ asset($transaction->receipt_path) }}" download class="btn-custom btn-custom-primary py-2.5 px-4 flex-fill justify-content-center">
                <i class="fas fa-download"></i> Télécharger
            </a>
        </div>
    </div>
    @endif

    <div class="mt-5">
        <a href="{{ route('caissier.transactions.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection
