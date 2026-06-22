<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails transaction | Askya Finance</title>
    
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

        /* Page Header */
        .page-header {
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

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 15px;
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

        .detail-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-validée {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 200px;
            font-weight: 600;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .info-value {
            color: var(--text-dark);
            font-weight: 500;
        }

        .amount-display {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .btn-back {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
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

            .detail-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-label {
                width: 100%;
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
                        <div class="role">Caissier</div>
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
                <a href="{{ route('caissier.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.transactions.create') }}">
                    <i class="fas fa-plus-circle"></i>
                    Nouvelle transaction
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.transactions.index') }}" class="active">
                    <i class="fas fa-list"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.search.index') }}">
                    <i class="fas fa-search"></i>
                    Recherche
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.caisse.index') }}">
                    <i class="fas fa-cash-register"></i>
                    Caisse
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('profile.edit') }}">
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
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('caissier.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Détails</li>
                </ol>
            </nav>
            <div class="page-title">
                <h1><i class="fas fa-receipt me-2"></i>Détails de la transaction</h1>
                <p>Informations complètes sur {{ $transaction['reference'] }}</p>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h2>{{ $transaction['reference'] }}</h2>
                    <span class="badge badge-{{ $transaction['statut'] }}">
                        {{ ucfirst(str_replace('_', ' ', $transaction['statut'])) }}
                    </span>
                </div>
                <div class="amount-display">
                    {{ number_format($transaction['total'], 0, ',', ' ') }} FCFA
                </div>
            </div>

            <div class="detail-info">
                <div class="info-row">
                    <div class="info-label">Type de transaction</div>
                    <div class="info-value">{{ $transaction['type'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Montant</div>
                    <div class="info-value">{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Frais</div>
                    <div class="info-value">{{ number_format($transaction['frais'], 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total</div>
                    <div class="info-value" style="color: var(--primary-blue); font-weight: 700;">
                        {{ number_format($transaction['total'], 0, ',', ' ') }} FCFA
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Client</div>
                    <div class="info-value">{{ $transaction['client'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Téléphone client</div>
                    <div class="info-value">{{ $transaction['telephone'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Caissier</div>
                    <div class="info-value">{{ $transaction['caissier'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ $transaction['date'] }}</div>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <a href="{{ route('caissier.transactions.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
