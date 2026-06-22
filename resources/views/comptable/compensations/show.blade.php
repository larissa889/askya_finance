<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Compensation | Askya Finance</title>
    
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

        /* Detail Card */
        .detail-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            max-width: 900px;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .detail-header .reference {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .detail-section {
            margin-bottom: 25px;
        }

        .detail-section h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 200px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-value {
            flex: 1;
            color: var(--text-dark);
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-en_attente {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .badge-validée {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .badge-payée {
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary-blue);
        }

        .btn-back {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--light-gray);
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

            .detail-card {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
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
                <a href="{{ route('comptable.solde.index') }}">
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
                <li class="breadcrumb-item"><a href="{{ route('comptable.compensations.index') }}">Compensations</a></li>
                <li class="breadcrumb-item active">Détails</li>
            </ol>
        </nav>

        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h3>Détails de la compensation</h3>
                    <p class="reference">{{ $compensation['reference'] }}</p>
                </div>
                <span class="badge badge-{{ $compensation['statut'] }}">
                    {{ ucfirst(str_replace('_', ' ', $compensation['statut'])) }}
                </span>
            </div>

            <div class="detail-section">
                <h4><i class="fas fa-exchange-alt me-2"></i>Informations compensation</h4>
                <div class="detail-row">
                    <div class="detail-label">Référence</div>
                    <div class="detail-value">{{ $compensation['reference'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Transaction</div>
                    <div class="detail-value">{{ $compensation['transaction'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Agence source</div>
                    <div class="detail-value">{{ $compensation['agence_source'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Agence destination</div>
                    <div class="detail-value">{{ $compensation['agence_destination'] }}</div>
                </div>
            </div>

            <div class="detail-section">
                <h4><i class="fas fa-money-bill-wave me-2"></i>Informations financières</h4>
                <div class="detail-row">
                    <div class="detail-label">Montant</div>
                    <div class="detail-value">{{ number_format($compensation['montant'], 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Frais</div>
                    <div class="detail-value">{{ number_format($compensation['frais'], 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Total</div>
                    <div class="detail-value" style="color: var(--primary-blue); font-size: 1.2rem;">
                        {{ number_format($compensation['total'], 0, ',', ' ') }} FCFA
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h4><i class="fas fa-info-circle me-2"></i>Informations système</h4>
                <div class="detail-row">
                    <div class="detail-label">Statut</div>
                    <div class="detail-value">
                        <span class="badge badge-{{ $compensation['statut'] }}">
                            {{ ucfirst(str_replace('_', ' ', $compensation['statut'])) }}
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Date</div>
                    <div class="detail-value">{{ $compensation['date'] }}</div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('comptable.compensations.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
