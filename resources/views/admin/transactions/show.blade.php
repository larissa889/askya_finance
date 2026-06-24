@extends('layouts.dashboard')

@section('title', 'Détails de la transaction')

@section('styles')
<style>
    .breadcrumb-custom {
        display: flex;
        flex-wrap: wrap;
        padding: 0 0 20px 0;
        margin-bottom: 20px;
        list-style: none;
        gap: 8px;
        font-size: 0.9rem;
    }
    .breadcrumb-custom a {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .breadcrumb-custom a:hover {
        color: #3b82f6;
    }
    .breadcrumb-custom .active {
        color: var(--text-muted);
    }
    .detail-container {
        max-width: 900px;
    }
    .detail-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-glass);
    }
    .amount-display {
        font-size: 2rem;
        font-weight: 800;
        color: #60a5fa;
        text-shadow: 0 0 15px rgba(96, 165, 250, 0.2);
    }
    .info-row-custom {
        display: flex;
        padding: 16px 0;
        border-bottom: 1px solid var(--border-glass);
        align-items: center;
    }
    .info-row-custom:last-child {
        border-bottom: none;
    }
    .info-label-custom {
        width: 220px;
        font-weight: 700;
        color: var(--text-muted);
        flex-shrink: 0;
    }
    .info-value-custom {
        color: var(--text-light);
        font-weight: 500;
    }
    @media (max-width: 768px) {
        .detail-header-custom {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .info-row-custom {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        .info-label-custom {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb-custom">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-house me-1"></i>Dashboard</a></li>
            <li class="text-muted">/</li>
            <li><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
            <li class="text-muted">/</li>
            <li class="active" aria-current="page">Détails</li>
        </ul>
    </nav>
    <div class="page-title">
        <h1><i class="fas fa-receipt me-2 text-primary"></i>Détails de la transaction</h1>
        <p>Informations complètes sur {{ $transaction['reference'] }}</p>
    </div>
</div>

<!-- Detail Card -->
<div class="detail-container">
    <div class="glass-card">
        <div class="detail-header-custom">
            <div>
                <h2 class="text-white mb-2 fw-extrabold">{{ $transaction['reference'] }}</h2>
                @php
                    $statusClass = $transaction['statut'] === 'validée' ? 'success' : ($transaction['statut'] === 'en_attente' ? 'warning' : 'danger');
                    $statusLabel = ucfirst(str_replace('_', ' ', $transaction['statut']));
                @endphp
                <span class="badge-premium badge-premium-{{ $statusClass }}">
                    <i class="fas {{ $statusClass === 'success' ? 'fa-circle-check' : ($statusClass === 'warning' ? 'fa-circle-dot' : 'fa-circle-xmark') }} me-1"></i>
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="amount-display">
                {{ number_format($transaction['total'], 0, ',', ' ') }} FCFA
            </div>
        </div>

        <div class="detail-info">
            <div class="info-row-custom">
                <div class="info-label-custom">Type de transaction</div>
                <div class="info-value-custom">{{ $transaction['type'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Montant</div>
                <div class="info-value-custom text-white fw-bold">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Frais</div>
                <div class="info-value-custom text-muted">{{ number_format($transaction['frais'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Total</div>
                <div class="info-value-custom text-white fw-extrabold fs-5">
                    {{ number_format($transaction['total'], 0, ',', ' ') }} FCFA
                </div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Client</div>
                <div class="info-value-custom text-white">{{ $transaction['client'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Téléphone client</div>
                <div class="info-value-custom">{{ $transaction['client_telephone'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Email client</div>
                <div class="info-value-custom">{{ $transaction['client_email'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Caissier</div>
                <div class="info-value-custom">{{ $transaction['caissier'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Date de création</div>
                <div class="info-value-custom">{{ $transaction['date_creation'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Date de validation</div>
                <div class="info-value-custom">{{ $transaction['date_validation'] }}</div>
            </div>
            <div class="info-row-custom">
                <div class="info-label-custom">Notes</div>
                <div class="info-value-custom text-muted italic">{{ $transaction['notes'] ?: 'Aucune note' }}</div>
            </div>
        </div>

        <div class="mt-4 pt-2">
            <a href="{{ route('admin.transactions.index') }}" class="btn-custom">
                <i class="fas fa-arrow-left me-2 text-primary"></i>Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
