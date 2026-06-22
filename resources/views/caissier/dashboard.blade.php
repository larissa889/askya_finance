<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Caissier | Askya Finance</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0D8ABC;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0a6a8f 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Sidebar */
        .sidebar {
            background-color: white;
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--dark-text);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(13, 138, 188, 0.1);
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }

        .sidebar-menu a i {
            width: 25px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0a6a8f 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(13, 138, 188, 0.3);
        }

        .welcome-section h2 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .welcome-section p {
            margin-bottom: 0;
            opacity: 0.9;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stat-card.primary .icon-wrapper {
            background-color: rgba(13, 138, 188, 0.15);
            color: var(--primary-color);
        }

        .stat-card.success .icon-wrapper {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-color);
        }

        .stat-card.warning .icon-wrapper {
            background-color: rgba(255, 193, 7, 0.15);
            color: var(--warning-color);
        }

        .stat-card.danger .icon-wrapper {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger-color);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--secondary-color);
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-btn {
            padding: 20px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 100%;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .action-btn i {
            font-size: 1.3rem;
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .table-container h4 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-text);
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #dee2e6;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 138, 188, 0.05);
        }

        .badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: rgba(255, 193, 7, 0.15);
            color: #856404;
        }

        .badge-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger-color);
        }

        /* Cash Summary */
        .cash-summary {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .cash-summary h4 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-text);
        }

        .cash-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .cash-item:last-child {
            border-bottom: none;
        }

        .cash-item .label {
            font-weight: 500;
            color: var(--secondary-color);
        }

        .cash-item .value {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .cash-item.total .value {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        /* Notifications */
        .notifications {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .notifications h4 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-text);
        }

        .notification-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background-color: rgba(13, 138, 188, 0.05);
        }

        .notification-item .icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-item.success .icon {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-color);
        }

        .notification-item.danger .icon {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger-color);
        }

        .notification-item.warning .icon {
            background-color: rgba(255, 193, 7, 0.15);
            color: #856404;
        }

        .notification-item .content {
            flex: 1;
        }

        .notification-item .content p {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .notification-item .content small {
            color: var(--secondary-color);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                min-height: auto;
            }

            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 10px;
            }

            .sidebar-menu li {
                margin-bottom: 0;
                margin-right: 5px;
                flex-shrink: 0;
            }

            .sidebar-menu a {
                padding: 10px 15px;
                white-space: nowrap;
            }

            .sidebar-menu a i {
                width: 20px;
                margin-right: 8px;
            }
        }

        @media (max-width: 768px) {
            .welcome-section {
                padding: 20px;
            }

            .welcome-section h2 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .action-btn {
                padding: 15px 20px;
                font-size: 0.9rem;
            }

            .table-container,
            .cash-summary,
            .notifications {
                padding: 15px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <i class="fas fa-coins"></i>
                Askya Finance
            </a>
            
            <div class="user-info text-white">
                <span class="d-none d-md-inline">{{ $caissier['nom'] }}</span>
                <img src="{{ $caissier['photo'] }}" alt="Photo de profil" class="user-avatar">
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="d-none d-md-inline">Déconnexion</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('caissier.dashboard') }}" class="active">
                                <i class="fas fa-home"></i>
                                Tableau de bord
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
                                Liste des transactions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('caissier.search.index') }}">
                                <i class="fas fa-search"></i>
                                Rechercher une transaction
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('caissier.caisse.index') }}">
                                <i class="fas fa-cash-register"></i>
                                Caisse
                            </a>
                        </li>
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
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 py-4">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h2>Bonjour, {{ $caissier['nom'] }}</h2>
                    <p>Bienvenue sur votre espace de travail. | {{ date('d/m/Y') }}</p>
                </div>

                <!-- Stat Cards -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card primary">
                            <div class="icon-wrapper">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <h3>{{ $statistiques['transactions_jour'] }}</h3>
                            <p>Transactions du jour</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card success">
                            <div class="icon-wrapper">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h3>{{ number_format($statistiques['montant_encaisse'], 0, ',', ' ') }} FCFA</h3>
                            <p>Montant encaissé aujourd'hui</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card warning">
                            <div class="icon-wrapper">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3>{{ $statistiques['transactions_attente'] }}</h3>
                            <p>Transactions en attente</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="stat-card danger">
                            <div class="icon-wrapper">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <h3>{{ $statistiques['transactions_annulees'] }}</h3>
                            <p>Transactions annulées</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-primary action-btn w-100">
                            <i class="fas fa-plus-circle"></i>
                            Nouvelle transaction
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-info action-btn w-100">
                            <i class="fas fa-list"></i>
                            Liste des transactions
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-secondary action-btn w-100">
                            <i class="fas fa-search"></i>
                            Recherche
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <button class="btn btn-success action-btn w-100">
                            <i class="fas fa-print"></i>
                            Imprimer un reçu
                        </button>
                    </div>
                </div>

                <!-- Table and Cash Summary -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-3">
                        <div class="table-container">
                            <h4><i class="fas fa-history me-2"></i>Dernières transactions</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Référence</th>
                                            <th>Client</th>
                                            <th>Montant</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td><strong>{{ $transaction['reference'] }}</strong></td>
                                            <td>{{ $transaction['client'] }}</td>
                                            <td>{{ number_format($transaction['montant'], 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $transaction['type'] }}</td>
                                            <td>{{ $transaction['date'] }}</td>
                                            <td>
                                                @if($transaction['statut'] == 'validée')
                                                    <span class="badge badge-success">Validée</span>
                                                @elseif($transaction['statut'] == 'en_attente')
                                                    <span class="badge badge-warning">En attente</span>
                                                @elseif($transaction['statut'] == 'annulée')
                                                    <span class="badge badge-danger">Annulée</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="cash-summary">
                            <h4><i class="fas fa-cash-register me-2"></i>Résumé de caisse</h4>
                            <div class="cash-item">
                                <span class="label">Ouverture de caisse</span>
                                <span class="value">{{ number_format($caisse['ouverture'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="cash-item">
                                <span class="label">Encaissements</span>
                                <span class="value text-success">+{{ number_format($caisse['encaissements'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="cash-item">
                                <span class="label">Décaissements</span>
                                <span class="value text-danger">-{{ number_format($caisse['decaissements'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="cash-item total">
                                <span class="label">Solde actuel</span>
                                <span class="value">{{ number_format($caisse['solde'], 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="notifications">
                            <h4><i class="fas fa-bell me-2"></i>Notifications</h4>
                            @foreach($notifications as $notification)
                            <div class="notification-item {{ $notification['type'] }}">
                                <div class="icon">
                                    @if($notification['type'] == 'success')
                                        <i class="fas fa-check"></i>
                                    @elseif($notification['type'] == 'danger')
                                        <i class="fas fa-times"></i>
                                    @elseif($notification['type'] == 'warning')
                                        <i class="fas fa-exclamation-triangle"></i>
                                    @endif
                                </div>
                                <div class="content">
                                    <p>{{ $notification['message'] }}</p>
                                    <small>{{ $notification['heure'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
