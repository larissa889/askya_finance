<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports | Askya Finance</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --primary-dark: #0F172A;
            --primary-blue: #2563EB;
            --primary-blue-light: #3b82f6;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-brand i {
            color: var(--primary-blue);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 260px;
            height: calc(100vh - 70px);
            background: var(--white);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.95rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(37, 99, 235, 0.05);
            border-left-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .sidebar-menu a i {
            width: 25px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border-color);
            margin: 15px 25px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .page-title p {
            color: var(--text-muted);
            margin-bottom: 0;
        }

        .export-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-export {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-export:hover {
            background: var(--light-gray);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .stat-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stat-card.primary .icon-wrapper {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(59, 130, 246, 0.15) 100%);
            color: var(--primary-blue);
        }

        .stat-card.success .icon-wrapper {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: var(--success);
        }

        .stat-card.warning .icon-wrapper {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 191, 36, 0.15) 100%);
            color: var(--warning);
        }

        .stat-card.info .icon-wrapper {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(34, 211, 238, 0.15) 100%);
            color: var(--info);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .stat-card p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Chart Cards */
        .chart-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .chart-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .export-buttons {
                width: 100%;
                flex-wrap: wrap;
            }

            .btn-export {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .header-brand {
                font-size: 1.2rem;
            }

            .main-content {
                padding: 20px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .chart-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-brand">
                <i class="fas fa-coins"></i>
                <span>Askya Finance</span>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    Gestion des utilisateurs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    Transactions globales
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}" class="active">
                    <i class="fas fa-chart-bar"></i>
                    Rapports
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog"></i>
                    Paramètres
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h1><i class="fas fa-chart-bar me-2"></i>Rapports</h1>
                <p>Statistiques et analyses de la plateforme</p>
            </div>
            <div class="export-buttons">
                <button class="btn btn-export" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Imprimer
                </button>
                <button class="btn btn-export">
                    <i class="fas fa-file-pdf"></i>
                    Export PDF
                </button>
                <button class="btn btn-export">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card primary">
                    <div class="icon-wrapper">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3>{{ number_format($statistiques['total_transactions'], 0, ',', ' ') }}</h3>
                    <p>Total transactions</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card success">
                    <div class="icon-wrapper">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>{{ number_format($statistiques['montant_total'], 0, ',', ' ') }} FCFA</h3>
                    <p>Montant total</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card warning">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>{{ $statistiques['nombre_caissiers'] }}</h3>
                    <p>Caissiers actifs</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card info">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>{{ $statistiques['nombre_superviseurs'] + $statistiques['nombre_comptables'] + $statistiques['nombre_admins'] }}</h3>
                    <p>Autres utilisateurs</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="chart-card">
                    <h4><i class="fas fa-chart-line me-2"></i>Transactions par mois</h4>
                    <canvas id="transactionsChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="chart-card">
                    <h4><i class="fas fa-chart-pie me-2"></i>Transactions par statut</h4>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="chart-card">
                    <h4><i class="fas fa-chart-bar me-2"></i>Répartition des utilisateurs par rôle</h4>
                    <canvas id="rolesChart" height="200"></canvas>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="chart-card">
                    <h4><i class="fas fa-info-circle me-2"></i>Informations supplémentaires</h4>
                    <div style="padding: 20px;">
                        <div style="margin-bottom: 15px;">
                            <strong style="color: var(--text-dark);">Nombre de superviseurs :</strong>
                            <span style="color: var(--warning); font-weight: 600; margin-left: 10px;">{{ $statistiques['nombre_superviseurs'] }}</span>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: var(--text-dark);">Nombre de comptables :</strong>
                            <span style="color: var(--success); font-weight: 600; margin-left: 10px;">{{ $statistiques['nombre_comptables'] }}</span>
                        </div>
                        <div>
                            <strong style="color: var(--text-dark);">Nombre d'administrateurs :</strong>
                            <span style="color: var(--danger); font-weight: 600; margin-left: 10px;">{{ $statistiques['nombre_admins'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js Configuration -->
    <script>
        // Transactions par mois
        const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
        new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: @json(array_keys($transactions_par_mois)),
                datasets: [{
                    label: 'Transactions',
                    data: @json(array_values($transactions_par_mois)),
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
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
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
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
                            usePointStyle: true
                        }
                    }
                },
                cutout: '65%'
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
                    backgroundColor: ['#2563EB', '#f59e0b', '#10b981', '#ef4444'],
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
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
