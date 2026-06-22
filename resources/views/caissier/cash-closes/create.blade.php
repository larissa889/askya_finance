<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle clôture de caisse | Askya Finance</title>
    
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

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Cash Close Card */
        .cash-close-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        .cash-close-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--text-dark);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }

        .balance-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .balance-row:last-child {
            border-bottom: none;
        }

        .balance-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .balance-value {
            color: var(--text-dark);
            font-weight: 600;
        }

        .balance-value.positive {
            color: var(--success);
        }

        .balance-value.negative {
            color: var(--danger);
        }

        .balance-final {
            background: rgba(37, 99, 235, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .balance-final .balance-label {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .balance-final .balance-value {
            font-size: 1.2rem;
            color: var(--primary-blue);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background: var(--text-muted);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--text-dark);
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
                <a href="{{ route('caissier.transactions.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.cash-closes.index') }}" class="active">
                    <i class="fas fa-cash-register"></i>
                    Clôtures de caisse
                </a>
            </li>
            <li>
                <a href="{{ route('caissier.search.index') }}">
                    <i class="fas fa-search"></i>
                    Recherche
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-cash-register me-2"></i>Nouvelle clôture de caisse</h2>
            <a href="{{ route('caissier.cash-closes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>

        <form action="{{ route('caissier.cash-closes.store') }}" method="POST">
            @csrf

            <!-- Agence Info -->
            <div class="cash-close-card">
                <h4><i class="fas fa-building me-2"></i>Informations de l'agence</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Agence:</strong> {{ $agency->name }}</p>
                        <p><strong>Code:</strong> {{ $agency->code }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
                        <p><strong>Transactions:</strong> {{ $transactions->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Situation du compte -->
            <div class="cash-close-card">
                <h4><i class="fas fa-wallet me-2"></i>Situation du compte</h4>
                <div class="section-title">Monnaie électronique</div>
                <div class="balance-row">
                    <span class="balance-label">Solde initial</span>
                    <span class="balance-value">{{ number_format($preview['account_initial_balance'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Approvisionnement</span>
                    <span class="balance-value positive">+{{ number_format($preview['account_provisioning'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Paiements</span>
                    <span class="balance-value negative">-{{ number_format($preview['account_payments'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Dépôts</span>
                    <span class="balance-value positive">+{{ number_format($preview['account_deposits'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Sorties</span>
                    <span class="balance-value negative">-{{ number_format($preview['account_outputs'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-final">
                    <div class="balance-row">
                        <span class="balance-label">Solde final</span>
                        <span class="balance-value">{{ number_format($preview['account_final_balance'], 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Situation de la caisse -->
            <div class="cash-close-card">
                <h4><i class="fas fa-money-bill-wave me-2"></i>Situation de la caisse</h4>
                <div class="section-title">Espèces</div>
                <div class="balance-row">
                    <span class="balance-label">Solde initial</span>
                    <span class="balance-value">{{ number_format($preview['cash_initial_balance'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Approvisionnement</span>
                    <span class="balance-value positive">+{{ number_format($preview['cash_provisioning'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Dépôts</span>
                    <span class="balance-value positive">+{{ number_format($preview['cash_deposits'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Paiements</span>
                    <span class="balance-value negative">-{{ number_format($preview['cash_payments'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Sorties</span>
                    <span class="balance-value negative">-{{ number_format($preview['cash_outputs'], 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-final">
                    <div class="balance-row">
                        <span class="balance-label">Solde final</span>
                        <span class="balance-value">{{ number_format($preview['cash_final_balance'], 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Observations -->
            <div class="cash-close-card">
                <h4><i class="fas fa-sticky-note me-2"></i>Observations</h4>
                <div class="mb-3">
                    <label for="observations" class="form-label">Observations éventuelles</label>
                    <textarea class="form-control" id="observations" name="observations" rows="3" placeholder="Ajoutez vos observations...">{{ old('observations') }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('caissier.cash-closes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check me-2"></i>Confirmer la clôture
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
