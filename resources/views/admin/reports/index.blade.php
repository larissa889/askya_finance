@extends('layouts.dashboard')

@section('title', 'Rapports')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div class="page-title">
        <h1><i class="fas fa-chart-bar me-2 text-primary"></i>Rapports</h1>
        <p>Statistiques et analyses de la plateforme</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <button class="btn-custom py-2 px-3" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <button class="btn-custom py-2 px-3">
            <i class="fas fa-file-pdf text-danger"></i> Export PDF
        </button>
        <button class="btn-custom btn-custom-success py-2 px-3">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['total_transactions'], 0, ',', ' ') }}</h3>
                <p>Total transactions</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['montant_total'], 0, ',', ' ') }} FCFA</h3>
                <p>Montant total</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium warning">
            <div class="icon-box">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <h3>{{ $statistiques['nombre_caissiers'] }}</h3>
                <p>Caissiers actifs</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h3>{{ $statistiques['nombre_superviseurs'] + $statistiques['nombre_comptables'] + $statistiques['nombre_admins'] }}</h3>
                <p>Autres utilisateurs</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-5">
    <div class="col-xl-8">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-line text-primary fs-5"></i>
                <span>Transactions par mois</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="transactionsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-pie text-primary fs-5"></i>
                <span>Transactions par statut</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-chart-bar text-primary fs-5"></i>
                <span>Répartition des utilisateurs par rôle</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="rolesChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-info-circle text-primary fs-5"></i>
                <span>Informations supplémentaires</span>
            </h4>
            <div class="p-3 d-flex flex-column gap-4">
                <div class="d-flex align-items-center justify-content-between p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2.5 rounded-3 bg-warning bg-opacity-15 text-warning">
                            <i class="fas fa-user-shield fs-5"></i>
                        </div>
                        <span class="text-white fw-semibold">Nombre de superviseurs</span>
                    </div>
                    <span class="fs-4 fw-bold text-warning">{{ $statistiques['nombre_superviseurs'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2.5 rounded-3 bg-success bg-opacity-15 text-success">
                            <i class="fas fa-scale-balanced fs-5"></i>
                        </div>
                        <span class="text-white fw-semibold">Nombre de comptables</span>
                    </div>
                    <span class="fs-4 fw-bold text-success">{{ $statistiques['nombre_comptables'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2.5 rounded-3 bg-danger bg-opacity-15 text-danger">
                            <i class="fas fa-user-gear fs-5"></i>
                        </div>
                        <span class="text-white fw-semibold">Nombre d'administrateurs</span>
                    </div>
                    <span class="fs-4 fw-bold text-danger">{{ $statistiques['nombre_admins'] }}</span>
                </div>
            </div>
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

        // Transactions par mois
        const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
        new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: @json(array_keys($transactions_par_mois)),
                datasets: [{
                    label: 'Transactions',
                    data: @json(array_values($transactions_par_mois)),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#070a13',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Transactions par statut
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($transactions_par_statut)),
                datasets: [{
                    data: @json(array_values($transactions_par_statut)),
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
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
                            usePointStyle: true,
                            font: { family: 'Plus Jakarta Sans', weight: 'bold' }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Utilisateurs par rôle
        const rolesCtx = document.getElementById('rolesChart').getContext('2d');
        new Chart(rolesCtx, {
            type: 'bar',
            data: {
                labels: @json(array_keys($utilisateurs_par_role)),
                datasets: [{
                    label: 'Utilisateurs',
                    data: @json(array_values($utilisateurs_par_role)),
                    backgroundColor: ['#3b82f6', '#fbbf24', '#34d399', '#f87171'],
                    borderWidth: 0,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
