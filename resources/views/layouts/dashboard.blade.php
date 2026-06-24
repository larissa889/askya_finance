<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Askya Finance</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #070a13;
            --bg-darker: #05070d;
            --card-glass: rgba(17, 24, 39, 0.5);
            --border-glass: rgba(255, 255, 255, 0.08);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --sidebar-width: 280px;
            --header-height: 70px;
            
            --primary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Mesh Gradients en arrière-plan */
        .bg-mesh-1 {
            position: fixed;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            pointer-events: none;
        }

        .bg-mesh-2 {
            position: fixed;
            bottom: -10%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            pointer-events: none;
        }

        /* Header */
        .header {
            background: rgba(7, 10, 19, 0.8);
            border-bottom: 1px solid var(--border-glass);
            height: var(--header-height);
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            backdrop-filter: blur(15px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-brand {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-brand i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 8px rgba(59, 130, 246, 0.4));
        }

        .header-brand span {
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glass);
            padding: 6px 14px;
            border-radius: 50px;
        }

        .header-user-info {
            text-align: right;
        }

        .header-user-info .name {
            font-weight: 700;
            font-size: 0.85rem;
            color: #f1f5f9;
        }

        .header-user-info .role {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .header-user img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
        }

        .menu-toggle-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glass);
            color: var(--text-light);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .menu-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: rgba(5, 7, 13, 0.7);
            border-right: 1px solid var(--border-glass);
            backdrop-filter: blur(25px);
            z-index: 999;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 30px 20px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            gap: 14px;
        }

        .sidebar-menu a i {
            font-size: 1.15rem;
            width: 24px;
            text-align: center;
            transition: transform 0.25s ease;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-light);
        }

        .sidebar-menu a:hover i {
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .sidebar-menu a.active i {
            color: #60a5fa;
            filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.5));
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border-glass);
            margin: 20px 10px;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 40px;
            min-height: calc(100vh - var(--header-height));
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Page Layout Components */
        .page-header {
            margin-bottom: 35px;
            animation: fadeInDown 0.6s ease-out;
        }

        .page-title h1 {
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-title p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 1.05rem;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--card-glass);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0 30px 30px rgba(0, 0, 0, 0.25),
                        border-color 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(255, 255, 255, 0.12);
        }

        /* Premium Stat Card */
        .stat-card-premium {
            background: var(--card-glass);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .stat-card-premium:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
        }

        .stat-card-premium .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card-premium.primary .icon-box {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.2);
        }

        .stat-card-premium.success .icon-box {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .stat-card-premium.warning .icon-box {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.2);
        }

        .stat-card-premium.danger .icon-box {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .stat-card-premium.info .icon-box {
            background: rgba(6, 182, 212, 0.15);
            color: #22d3ee;
            border-color: rgba(6, 182, 212, 0.2);
        }

        .stat-card-premium h3 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .stat-card-premium p {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        /* Tables */
        .table-responsive-custom {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid var(--border-glass);
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0;
            color: var(--text-light);
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background: rgba(15, 23, 42, 0.6);
            color: #cbd5e1;
            font-weight: 700;
            padding: 18px 20px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-glass);
        }

        .table-custom td {
            padding: 16px 20px;
            vertical-align: middle;
            background: transparent;
            border-bottom: 1px solid var(--border-glass);
            font-size: 0.95rem;
            color: #e2e8f0;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Badges */
        .badge-premium {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid transparent;
        }

        .badge-premium-success {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .badge-premium-warning {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.2);
        }

        .badge-premium-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .badge-premium-info {
            background: rgba(6, 182, 212, 0.12);
            color: #22d3ee;
            border-color: rgba(6, 182, 212, 0.2);
        }

        /* Buttons */
        .btn-custom {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glass);
            color: var(--text-light);
            border-radius: 12px;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.18);
            color: white;
            transform: translateY(-1px);
        }

        .btn-custom-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .btn-custom-primary:hover {
            background: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }

        .btn-custom-success {
            background: var(--success);
            border-color: var(--success);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .btn-custom-success:hover {
            background: #059669;
            border-color: #059669;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-custom-danger {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .btn-custom-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
        }

        /* Forms */
        .form-label-custom {
            font-weight: 700;
            color: #e2e8f0;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--border-glass) !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-size: 0.95rem;
            color: var(--text-light) !important;
            transition: all 0.3s ease;
        }

        .form-control-custom::placeholder {
            color: rgba(148, 163, 184, 0.4);
        }

        .form-control-custom:focus {
            outline: none !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            background: rgba(255, 255, 255, 0.04) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        .form-select-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 16px center !important;
            background-size: 12px 12px !important;
            padding-right: 40px !important;
        }

        /* Modal styling */
        .modal-content-custom {
            background: #0a0f1d;
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
        }

        .modal-header-custom {
            border-bottom: 1px solid var(--border-glass);
            padding: 20px 24px;
        }

        .modal-body-custom {
            padding: 24px;
        }

        .modal-footer-custom {
            border-top: 1px solid var(--border-glass);
            padding: 20px 24px;
        }

        /* Custom Alert Message */
        .alert-custom {
            border-radius: 12px;
            border: 1px solid rgba(239, 68, 68, 0.15);
            background: rgba(239, 68, 68, 0.06);
            color: #f87171;
            padding: 16px 20px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-custom-success {
            border-color: rgba(16, 185, 129, 0.15);
            background: rgba(16, 185, 129, 0.06);
            color: #34d399;
        }

        .alert-custom-warning {
            border-color: rgba(245, 158, 11, 0.15);
            background: rgba(245, 158, 11, 0.06);
            color: #fbbf24;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Layout Settings */
        @media (max-width: 991px) {
            .menu-toggle-btn {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
                top: 0;
                height: 100vh;
                z-index: 1001;
                background: #05070d;
                box-shadow: 15px 0 35px rgba(0, 0, 0, 0.5);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 30px 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="bg-mesh-1"></div>
    <div class="bg-mesh-2"></div>

    <!-- Header -->
    <header class="header">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle-btn" id="menuToggleBtn">
                <i class="fas fa-bars"></i>
            </button>
            <a href="#" class="header-brand">
                <i class="fas fa-wallet"></i>
                <span>Askya Finance</span>
            </a>
        </div>
        
        <div class="header-actions">
            @auth
            <div class="header-user">
                <div class="header-user-info d-none d-md-block">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->role ? Auth::user()->role->label() : 'Utilisateur' }}</div>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" alt="Avatar">
            </div>
            <a href="{{ route('logout') }}" class="btn-custom" title="Déconnexion">
                <i class="fas fa-sign-out-alt"></i>
                <span class="d-none d-md-inline">Déconnexion</span>
            </a>
            @endauth
        </div>
    </header>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        @auth
        <div class="d-md-none mb-4 d-flex align-items-center gap-3 bg-white bg-opacity-5 p-3 rounded-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" alt="Avatar" class="rounded-circle" style="width: 45px; height: 45px;">
            <div>
                <div class="name fw-bold text-white fs-6">{{ Auth::user()->name }}</div>
                <div class="role text-muted font-semibold" style="font-size: 0.75rem;">{{ Auth::user()->role ? Auth::user()->role->label() : '' }}</div>
            </div>
        </div>
        @endauth

        <ul class="sidebar-menu">
            @auth
                <!-- Menu Caissier -->
                @if(Auth::user()->role && Auth::user()->role->value === 'caissier')
                    <li>
                        <a href="{{ route('caissier.dashboard') }}" class="{{ Route::is('caissier.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-grid-2"></i>
                            <i class="fas fa-house"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('caissier.transactions.index') }}" class="{{ Route::is('caissier.transactions.*') && !Route::is('caissier.transactions.create') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('caissier.search.index') }}" class="{{ Route::is('caissier.search.*') ? 'active' : '' }}">
                            <i class="fas fa-magnifying-glass"></i>
                            <span>Recherche</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('caissier.caisse.index') }}" class="{{ Route::is('caissier.caisse.*') ? 'active' : '' }}">
                            <i class="fas fa-cash-register"></i>
                            <span>Ma caisse</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('caissier.end-of-day.index') }}" class="{{ Route::is('caissier.end-of-day.*') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i>
                            <span>Fiche d'arrêt</span>
                        </a>
                    </li>
                @endif

                <!-- Menu Superviseur -->
                @if(Auth::user()->role && Auth::user()->role->value === 'superviseur')
                    <li>
                        <a href="{{ route('superviseur.dashboard') }}" class="{{ Route::is('superviseur.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-house"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superviseur.validation.index') }}" class="{{ Route::is('superviseur.validation.*') ? 'active' : '' }}">
                            <i class="fas fa-circle-check"></i>
                            <span>Validations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superviseur.transactions.index') }}" class="{{ Route::is('superviseur.transactions.*') ? 'active' : '' }}">
                            <i class="fas fa-list-check"></i>
                            <span>Toutes les transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superviseur.reports.index') }}" class="{{ Route::is('superviseur.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
                @endif

                <!-- Menu Comptable -->
                @if(Auth::user()->role && Auth::user()->role->value === 'comptable')
                    <li>
                        <a href="{{ route('comptable.dashboard') }}" class="{{ Route::is('comptable.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-house"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('comptable.compensations.index') }}" class="{{ Route::is('comptable.compensations.*') ? 'active' : '' }}">
                            <i class="fas fa-scale-balanced"></i>
                            <span>Compensations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('comptable.solde.index') }}" class="{{ Route::is('comptable.solde.*') ? 'active' : '' }}">
                            <i class="fas fa-wallet"></i>
                            <span>Soldes agences</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('comptable.reports.index') }}" class="{{ Route::is('comptable.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
                @endif

                <!-- Menu Administrateur -->
                @if(Auth::user()->role && Auth::user()->role->value === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-house"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users-gear"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transactions.index') }}" class="{{ Route::is('admin.transactions.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="{{ Route::is('admin.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-file-shield"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="{{ Route::is('admin.settings.*') ? 'active' : '' }}">
                            <i class="fas fa-sliders"></i>
                            <span>Configuration</span>
                        </a>
                    </li>
                @endif

                <div class="sidebar-divider"></div>
                
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ Route::is('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Mon profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            @endauth
        </ul>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Session alerts -->
        @if(session('success'))
            <div class="alert-custom alert-custom-success">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom">
                <i class="fas fa-circle-xmark"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navigation toggler script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggleBtn = document.getElementById('menuToggleBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            }

            if (menuToggleBtn && sidebar && sidebarOverlay) {
                menuToggleBtn.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
