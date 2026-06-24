@extends('layouts.dashboard')

@section('title', 'Tableau de Bord - Admin')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Bonjour, {{ Auth::user()->name }}</h1>
        <p>Bienvenue sur votre espace administrateur. | {{ date('d/m/Y') }}</p>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium primary">
            <div class="icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h3>{{ $statistiques['total_utilisateurs'] }}</h3>
                <p>Total utilisateurs</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium success">
            <div class="icon-box">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <h3>{{ $statistiques['caissiers_actifs'] }}</h3>
                <p>Caissiers actifs</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium warning">
            <div class="icon-box">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <h3>{{ $statistiques['transactions_jour'] }}</h3>
                <p>Transactions du jour</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-premium info">
            <div class="icon-box">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <h3>{{ number_format($statistiques['volume_financier'], 0, ',', ' ') }} FCFA</h3>
                <p>Volume financier total</p>
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
                <span>Évolution des transactions</span>
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
                <span>Utilisateurs par rôle</span>
            </h4>
            <div style="position: relative; height: 320px;">
                <canvas id="rolesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="glass-card mb-5">
    <h4 class="mb-4 fw-bold text-white"><i class="fas fa-bolt text-primary me-2"></i>Actions rapides</h4>
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.users.index') }}" class="btn-custom btn-custom-primary w-100 py-3 justify-content-center">
                <i class="fas fa-users"></i>
                <span>Gestion des utilisateurs</span>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.transactions.index') }}" class="btn-custom w-100 py-3 justify-content-center">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.reports.index') }}" class="btn-custom w-100 py-3 justify-content-center">
                <i class="fas fa-chart-bar"></i>
                <span>Rapports</span>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.settings.index') }}" class="btn-custom w-100 py-3 justify-content-center">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </div>
    </div>
</div>

<!-- Table & Activities Grid -->
<div class="row g-4 mb-5">
    <!-- Users list -->
    <div class="col-xl-8">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-users text-primary fs-5"></i>
                    <span>Utilisateurs récents</span>
                </h4>
                <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none fw-bold small d-flex align-items-center gap-1">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Rôle</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utilisateurs as $utilisateur)
                        <tr style="cursor: pointer;" onclick="window.location.href='{{ route('admin.users.index') }}'">
                            <td><strong>{{ $utilisateur['nom'] }}</strong></td>
                            <td>
                                @if($utilisateur['role'] === 'admin')
                                    <span class="badge-premium badge-premium-danger">Admin</span>
                                @elseif($utilisateur['role'] === 'superviseur')
                                    <span class="badge-premium badge-premium-warning">Superviseur</span>
                                @elseif($utilisateur['role'] === 'comptable')
                                    <span class="badge-premium badge-premium-success">Comptable</span>
                                @else
                                    <span class="badge-premium badge-premium-info">{{ ucfirst($utilisateur['role']) }}</span>
                                @endif
                            </td>
                            <td>{{ $utilisateur['email'] }}</td>
                            <td>
                                @if($utilisateur['statut'] === 'actif')
                                    <span class="badge-premium badge-premium-success">Actif</span>
                                @else
                                    <span class="badge-premium">Inactif</span>
                                @endif
                            </td>
                            <td>{{ $utilisateur['date_creation'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-xl-4">
        <div class="glass-card h-100">
            <h4 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-history text-primary fs-5"></i>
                <span>Activité récente</span>
            </h4>
            
            <div class="d-flex flex-column gap-3">
                @foreach($activites as $activite)
                <div class="d-flex align-items-start gap-3 p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-glass);">
                    <div class="d-flex align-items-center justify-content-center rounded-3 fs-5" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1); color: #60a5fa; flex-shrink: 0;">
                        <i class="fas {{ $activite['icone'] }}"></i>
                    </div>
                    <div>
                        <p class="text-white mb-1 fw-semibold" style="font-size: 0.9rem;">{{ $activite['message'] }}</p>
                        <span class="text-muted small"><i class="fas fa-clock me-1"></i>{{ $activite['heure'] }}</span>
                    </div>
                </div>
                @endforeach
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

        // Transactions Chart
        const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
        new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Transactions',
                    data: [850, 920, 1100, 980, 1247, 750, 420],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
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

        // Roles Chart
        const rolesCtx = document.getElementById('rolesChart').getContext('2d');
        new Chart(rolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Caissiers', 'Superviseurs', 'Comptables', 'Admins'],
                datasets: [{
                    data: [42, 18, 12, 4],
                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#10b981',
                        '#ef4444'
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
                            usePointStyle: true,
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

