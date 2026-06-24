@extends('layouts.dashboard')

@section('title', 'Rapports Financiers')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('comptable.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Rapports financiers</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Rapports financiers</h1>
        <p>Visualisez l'état financier global, l'évolution de vos soldes et les compensations.</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <h3>{{ $statistiques['total_compensations'] }}</h3>
                <p>Total compensations</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['total_credits'], 0, ',', ' ') }} FCFA</h3>
                <p>Total crédits</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['total_debits'], 0, ',', ' ') }} FCFA</h3>
                <p>Total débits</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['solde_global'], 0, ',', ' ') }} FCFA</h3>
                <p>Solde global</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-line text-primary fs-5"></i>
                <span>Évolution du solde</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="evolutionSolde"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-bar text-primary fs-5"></i>
                <span>Compensations par période</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="compensationsPeriode"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Doughnut chart full width -->
<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
        <i class="fas fa-chart-pie text-primary fs-5"></i>
        <span>Répartition des opérations financières</span>
    </h4>
    <div style="position: relative; height: 320px; max-width: 500px; margin: 0 auto;">
        <canvas id="repartitionOperations"></canvas>
    </div>
</div>

<!-- Export Controls Card -->
<div class="glass-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold text-white mb-1"><i class="fas fa-file-export text-primary me-2"></i>Exporter les rapports</h4>
            <p class="mb-0 text-muted small">Téléchargez ou imprimez le relevé complet des rapports financiers.</p>
        </div>
        
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn-custom py-2.5 px-4" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer
            </button>
            <form action="{{ route('comptable.export') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn-custom py-2.5 px-4">
                    <i class="fas fa-file-pdf text-danger"></i> Format PDF
                </button>
            </form>
            <form action="{{ route('comptable.export') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="format" value="excel">
                <button type="submit" class="btn-custom btn-custom-success py-2.5 px-4">
                    <i class="fas fa-file-excel"></i> Format Excel
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration globale de Chart.js pour thème sombre
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';

        // Chart 1: Evolution du solde (Line Chart)
        const ctxEvolution = document.getElementById('evolutionSolde').getContext('2d');
        new Chart(ctxEvolution, {
            type: 'line',
            data: {
                labels: @json($evolution_solde['labels']),
                datasets: [{
                    label: 'Solde (FCFA)',
                    data: @json($evolution_solde['data']),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: false }
                }
            }
        });

        // Chart 2: Compensations par période (Bar Chart)
        const ctxPeriode = document.getElementById('compensationsPeriode').getContext('2d');
        new Chart(ctxPeriode, {
            type: 'bar',
            data: {
                labels: @json($compensations_periode['labels']),
                datasets: [{
                    label: 'Compensations',
                    data: @json($compensations_periode['data']),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart 3: Répartition des opérations (Doughnut Chart)
        const ctxRepartition = document.getElementById('repartitionOperations').getContext('2d');
        new Chart(ctxRepartition, {
            type: 'doughnut',
            data: {
                labels: @json($repartition_operations['labels']),
                datasets: [{
                    data: @json($repartition_operations['data']),
                    backgroundColor: [
                        '#10b981', // encaissement
                        '#ef4444'  // decaissement
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { family: 'Plus Jakarta Sans', weight: 'bold' }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>
@endsection

