<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Askya Finance</title>
    
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

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
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

        .header-welcome {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .header-welcome strong {
            color: var(--text-dark);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-date {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .header-notifications {
            position: relative;
            cursor: pointer;
        }

        .header-notifications i {
            font-size: 1.2rem;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .header-notifications:hover i {
            color: var(--primary-blue);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: var(--white);
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .header-profile:hover {
            background-color: var(--light-gray);
        }

        .header-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-blue);
        }

        .header-profile-info {
            display: flex;
            flex-direction: column;
        }

        .header-profile-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .header-profile-role {
            font-size: 0.8rem;
            color: var(--text-muted);
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

        /* Stat Cards */
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

        /* Charts Section */
        .charts-section {
            margin-bottom: 30px;
        }

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

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 30px;
        }

        .action-btn {
            padding: 18px 25px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .action-btn i {
            font-size: 1.2rem;
        }

        .action-btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            color: var(--white);
        }

        .action-btn-secondary {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .action-btn-secondary:hover {
            background: var(--light-gray);
        }

        /* Table Section */
        .table-section {
            margin-bottom: 30px;
        }

        .table-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
        }

        .table-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .table thead th {
            background-color: var(--primary-dark);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 15px;
            font-size: 0.9rem;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: var(--border-color);
            font-size: 0.95rem;
        }

        .table tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.03);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-admin {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(248, 113, 113, 0.15) 100%);
            color: var(--danger);
        }

        .badge-caissier {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(59, 130, 246, 0.15) 100%);
            color: var(--primary-blue);
        }

        .badge-superviseur {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 191, 36, 0.15) 100%);
            color: var(--warning);
        }

        .badge-comptable {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: var(--success);
        }

        .badge-actif {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .badge-inactif {
            background: rgba(100, 116, 139, 0.15);
            color: var(--text-muted);
        }

        /* Activity Section */
        .activity-section {
            margin-bottom: 30px;
        }

        .activity-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
        }

        .activity-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .activity-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background-color: rgba(37, 99, 235, 0.03);
        }

        .activity-item .icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .activity-item.connexion .icon {
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary-blue);
        }

        .activity-item.creation .icon {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .activity-item.transaction .icon {
            background: rgba(6, 182, 212, 0.15);
            color: var(--info);
        }

        .activity-item.admin .icon {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .activity-item .content {
            flex: 1;
        }

        .activity-item .content p {
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .activity-item .content small {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
            }
        }

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

            .header-profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .header-brand {
                font-size: 1.2rem;
            }

            .header-welcome {
                display: none;
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

            .chart-card,
            .table-card,
            .activity-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-brand">
                        <i class="fas fa-coins"></i>
                        <span>Askya Finance</span>
                    </div>
                    <div class="header-welcome">
                        Bonjour, <strong>{{ $admin['nom'] }}</strong>
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-date">
                        {{ date('d/m/Y') }}
                    </div>
                    <div class="header-notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="header-profile">
                        <img src="{{ $admin['photo'] }}" alt="Photo de profil">
                        <div class="header-profile-info">
                            <span class="header-profile-name">{{ $admin['nom'] }}</span>
                            <span class="header-profile-role">Administrateur</span>
                        </div>
                        <i class="fas fa-chevron-down" style="color: var(--text-muted); font-size: 0.8rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="active">
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
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    Transactions globales
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}">
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
        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card primary">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>{{ $statistiques['total_utilisateurs'] }}</h3>
                    <p>Total utilisateurs</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card success">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>{{ $statistiques['caissiers_actifs'] }}</h3>
                    <p>Caissiers actifs</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card warning">
                    <div class="icon-wrapper">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3>{{ $statistiques['transactions_jour'] }}</h3>
                    <p>Transactions du jour</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card info">
                    <div class="icon-wrapper">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>{{ number_format($statistiques['volume_financier'], 0, ',', ' ') }} FCFA</h3>
                    <p>Volume financier total</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="chart-card">
                        <h4><i class="fas fa-chart-line me-2"></i>Évolution des transactions</h4>
                        <canvas id="transactionsChart" height="120"></canvas>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="chart-card">
                        <h4><i class="fas fa-chart-pie me-2"></i>Utilisateurs par rôle</h4>
                        <canvas id="rolesChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.users.index') }}" class="btn action-btn action-btn-primary w-100">
                        <i class="fas fa-users"></i>
                        Gestion des utilisateurs
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.transactions.index') }}" class="btn action-btn action-btn-secondary w-100">
                        <i class="fas fa-exchange-alt"></i>
                        Transactions
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.reports.index') }}" class="btn action-btn action-btn-secondary w-100">
                        <i class="fas fa-chart-bar"></i>
                        Rapports
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('admin.settings.index') }}" class="btn action-btn action-btn-secondary w-100">
                        <i class="fas fa-cog"></i>
                        Paramètres
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h4 style="margin-bottom: 0;"><i class="fas fa-users me-2"></i>Utilisateurs récents</h4>
                    <a href="{{ route('admin.users.index') }}" style="color: var(--primary-blue); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                    <span class="badge badge-{{ $utilisateur['role'] }}">
                                        {{ ucfirst($utilisateur['role']) }}
                                    </span>
                                </td>
                                <td>{{ $utilisateur['email'] }}</td>
                                <td>
                                    <span class="badge badge-{{ $utilisateur['statut'] }}">
                                        {{ ucfirst($utilisateur['statut']) }}
                                    </span>
                                </td>
                                <td>{{ $utilisateur['date_creation'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="activity-section">
            <div class="activity-card">
                <h4><i class="fas fa-history me-2"></i>Activité récente</h4>
                @foreach($activites as $activite)
                <div class="activity-item {{ $activite['type'] }}">
                    <div class="icon">
                        <i class="fas {{ $activite['icone'] }}"></i>
                    </div>
                    <div class="content">
                        <p>{{ $activite['message'] }}</p>
                        <small>{{ $activite['heure'] }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js Configuration -->
    <script>
        // Transactions Chart
        const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
        new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Transactions',
                    data: [850, 920, 1100, 980, 1247, 750, 420],
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

        // Roles Chart
        const rolesCtx = document.getElementById('rolesChart').getContext('2d');
        new Chart(rolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Caissiers', 'Superviseurs', 'Comptables', 'Admins'],
                datasets: [{
                    data: [42, 18, 12, 4],
                    backgroundColor: [
                        '#2563EB',
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
                            usePointStyle: true
                        }
                    }
                },
                cutout: '65%'
            }
        });
    </script>
</body>
</html>
