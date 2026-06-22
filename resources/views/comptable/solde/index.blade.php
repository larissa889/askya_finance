<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solde | Askya Finance</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
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

        .header-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-user-info {
            text-align: right;
        }

        .header-user-info .name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .header-user-info .role {
            color: var(--text-muted);
            font-size: 0.8rem;
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

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-blue);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            height: 100%;
            transition: all 0.3s ease;
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

        .stat-card.danger .icon-wrapper {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(248, 113, 113, 0.15) 100%);
            color: var(--danger);
        }

        .stat-card.info .icon-wrapper {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(34, 211, 238, 0.15) 100%);
            color: var(--info);
        }

        .stat-card h3 {
            font-size: 1.8rem;
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

        .stat-card .last-update {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 10px;
        }

        /* Table Card */
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

        /* Filters */
        .filters {
            background: var(--light-gray);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-filter {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background: #1d4ed8;
        }

        .btn-export {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            background: var(--light-gray);
        }

        /* Table */
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

        .text-credit {
            color: var(--success);
            font-weight: 600;
        }

        .text-debit {
            color: var(--danger);
            font-weight: 600;
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

            .table-card {
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
                <div class="header-brand">
                    <i class="fas fa-coins"></i>
                    <span>Askya Finance</span>
                </div>
                <div class="header-user">
                    <div class="header-user-info">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="role">Comptable</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=128" alt="Avatar">
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('comptable.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('comptable.compensations.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    Compensations
                </a>
            </li>
            <li>
                <a href="{{ route('comptable.solde.index') }}" class="active">
                    <i class="fas fa-wallet"></i>
                    Solde
                </a>
            </li>
            <li>
                <a href="{{ route('comptable.reports.index') }}">
                    <i class="fas fa-file-alt"></i>
                    Rapports financiers
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('comptable.profile.index') }}">
                    <i class="fas fa-user"></i>
                    Mon profil
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
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('comptable.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Solde</li>
            </ol>
        </nav>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card primary">
                    <div class="icon-wrapper">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3>{{ number_format($solde_info['solde_actuel'], 0, ',', ' ') }}</h3>
                    <p>Solde actuel (FCFA)</p>
                    <div class="last-update">
                        <i class="fas fa-clock me-1"></i>{{ $solde_info['derniere_maj'] }}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card success">
                    <div class="icon-wrapper">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <h3>{{ number_format($solde_info['total_credits'], 0, ',', ' ') }}</h3>
                    <p>Total crédits (FCFA)</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card danger">
                    <div class="icon-wrapper">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <h3>{{ number_format($solde_info['total_debits'], 0, ',', ' ') }}</h3>
                    <p>Total débits (FCFA)</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card info">
                    <div class="icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>{{ number_format($solde_info['solde_disponible'], 0, ',', ' ') }}</h3>
                    <p>Solde disponible (FCFA)</p>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4><i class="fas fa-list me-2"></i>Historique des opérations</h4>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn btn-export">
                        <i class="fas fa-file-pdf me-2"></i>PDF
                    </button>
                    <button type="button" class="btn btn-export">
                        <i class="fas fa-file-excel me-2"></i>Excel
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <form action="{{ route('comptable.solde.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="search" class="form-label">Rechercher</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Référence, description..." value="{{ $search }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_debut" class="form-label">Date début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" 
                                   value="{{ $date_debut }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_fin" class="form-label">Date fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" 
                                   value="{{ $date_fin }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-filter w-100">
                                <i class="fas fa-search me-2"></i>Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Description</th>
                            <th>Crédit</th>
                            <th>Débit</th>
                            <th>Solde après</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($operations as $operation)
                        <tr>
                            <td><strong>{{ $operation['reference'] }}</strong></td>
                            <td>{{ $operation['description'] }}</td>
                            <td>
                                @if($operation['credit'] > 0)
                                <span class="text-credit">+{{ number_format($operation['credit'], 0, ',', ' ') }} FCFA</span>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($operation['debit'] > 0)
                                <span class="text-debit">-{{ number_format($operation['debit'], 0, ',', ' ') }} FCFA</span>
                                @else
                                -
                                @endif
                            </td>
                            <td><strong>{{ number_format($operation['solde_apres'], 0, ',', ' ') }} FCFA</strong></td>
                            <td>{{ $operation['date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
