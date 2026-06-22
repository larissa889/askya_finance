<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche | Askya Finance</title>
    
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

        /* Search Card */
        .search-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            max-width: 900px;
        }

        .search-form {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .search-input {
            flex: 1;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .btn-search {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        /* Results Card */
        .results-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
        }

        .result-item {
            padding: 20px;
            border-radius: 12px;
            background: var(--light-gray);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .result-item:hover {
            background: rgba(37, 99, 235, 0.05);
        }

        .result-item:last-child {
            margin-bottom: 0;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .result-type {
            font-weight: 600;
            color: var(--primary-blue);
        }

        .result-info {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-transaction {
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary-blue);
        }

        .badge-client {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
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

            .search-form {
                flex-direction: column;
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

            .search-card {
                padding: 20px;
            }

            .results-card {
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
                <a href="{{ route('caissier.transactions.index') }}">
                    <i class="fas fa-list"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.search.index') }}" class="active">
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
            <div class="page-title">
                <h1><i class="fas fa-search me-2"></i>Recherche</h1>
                <p>Recherchez des transactions, des clients et plus encore</p>
            </div>
        </div>

        <!-- Search Card -->
        <div class="search-card">
            <form action="{{ route('caissier.search.index') }}" method="GET">
                <div class="search-form">
                    <input type="text" class="search-input" name="query" value="{{ $query ?? '' }}" placeholder="Rechercher une transaction, un client...">
                    <button type="submit" class="btn btn-search">
                        <i class="fas fa-search me-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Card -->
        @if($query && !empty($results))
        <div class="results-card" style="margin-top: 30px;">
            <h4 style="margin-bottom: 20px; font-size: 1.1rem; font-weight: 600; color: var(--text-dark);">
                <i class="fas fa-list me-2"></i>Résultats pour "{{ $query }}"
            </h4>
            @foreach($results as $result)
            <div class="result-item">
                <div class="result-header">
                    <span class="result-type">{{ $result['type'] == 'transaction' ? 'Transaction' : 'Client' }}</span>
                    <span class="badge badge-{{ $result['type'] }}">{{ ucfirst($result['type']) }}</span>
                </div>
                @if($result['type'] == 'transaction')
                <div class="result-info">
                    <strong>Référence:</strong> {{ $result['reference'] }} | 
                    <strong>Client:</strong> {{ $result['client'] }} | 
                    <strong>Montant:</strong> {{ number_format($result['montant'], 0, ',', ' ') }} FCFA
                </div>
                @else
                <div class="result-info">
                    <strong>Nom:</strong> {{ $result['nom'] }} | 
                    <strong>Téléphone:</strong> {{ $result['telephone'] }} | 
                    <strong>Email:</strong> {{ $result['email'] }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @elseif($query)
        <div class="results-card" style="margin-top: 30px;">
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-search" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 20px;"></i>
                <h4 style="color: var(--text-dark); margin-bottom: 10px;">Aucun résultat</h4>
                <p style="color: var(--text-muted);">Aucun résultat trouvé pour "{{ $query }}"</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
