@extends('layouts.dashboard')

@section('title', 'Rapports d\'activité')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('superviseur.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Rapports</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Rapports d'activité</h1>
        <p>Analysez les performances et statistiques financières de l'agence.</p>
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
                <h3>{{ $statistiques['total_jour'] }}</h3>
                <p>Transactions du jour</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h3>{{ $statistiques['validations'] }}</h3>
                <p>Validations effectuées</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium danger">
            <div class="icon-box">
                <i class="fas fa-circle-xmark"></i>
            </div>
            <div>
                <h3>{{ $statistiques['rejets'] }}</h3>
                <p>Rejets effectués</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['montant_total'], 0, ',', ' ') }} FCFA</h3>
                <p>Volume total traité</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-5">
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-line text-primary fs-5"></i>
                <span>Transactions par jour</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="transactionsParJour"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-pie text-primary fs-5"></i>
                <span>Répartition par statut</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="transactionsParStatut"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Export Controls Card -->
<div class="glass-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold text-white mb-1"><i class="fas fa-file-export text-primary me-2"></i>Exporter les rapports</h4>
            <p class="mb-0 text-muted small">Téléchargez les relevés de transactions de la journée sous différents formats.</p>
        </div>
        
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn-custom py-2.5 px-4" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer
            </button>
            <button type="button" class="btn-custom py-2.5 px-4">
                <i class="fas fa-file-pdf text-danger"></i> Format PDF
            </button>
            <button type="button" class="btn-custom btn-custom-success py-2.5 px-4">
                <i class="fas fa-file-excel text-success"></i> Format Excel
            </button>
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

        // Chart 1: Line Chart
        const ctxJour = document.getElementById('transactionsParJour').getContext('2d');
        new Chart(ctxJour, {
            type: 'line',
            data: {
                labels: @json($transactions_par_jour['labels']),
                datasets: [{
                    label: 'Transactions',
                    data: @json($transactions_par_jour['data']),
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
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart 2: Doughnut Chart
        const ctxStatut = document.getElementById('transactionsParStatut').getContext('2d');
        new Chart(ctxStatut, {
            type: 'doughnut',
            data: {
                labels: @json($transactions_par_statut['labels']),
                datasets: [{
                    data: @json($transactions_par_statut['data']),
                    backgroundColor: [
                        '#10b981', // validée
                        '#f59e0b', // en_attente
                        '#ef4444'  // rejetée
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
