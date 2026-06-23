<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name }} | Askya Finance</title>
    
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

        /* Main Content */
        .main-content {
            padding: 30px;
        }

        /* Service Header */
        .service-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .service-header h2 {
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 10px;
        }

        .service-header p {
            color: var(--secondary-color);
            margin-bottom: 0;
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 12px;
        }

        .service-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .service-icon i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        /* Operation Types */
        .operation-types {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .operation-types h4 {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 20px;
        }

        .operation-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .operation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .operation-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #0a6a8f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 1.5rem;
        }

        .operation-card h5 {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 10px;
        }

        .operation-card p {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        /* Back Button */
        .btn-back {
            background: var(--white);
            color: var(--dark-text);
            border: 1px solid #dee2e6;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--light-bg);
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
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=128" alt="Photo de profil" class="user-avatar">
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
                            <a href="{{ route('caissier.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Tableau de bord
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
                <div class="main-content">
                    <!-- Back Button -->
                    <a href="{{ route('caissier.dashboard') }}" class="btn btn-back mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
                    </a>

                    <!-- Service Header -->
                    <div class="service-header">
                        <div class="d-flex align-items-center">
                            <div class="service-icon me-4">
                                @if($service->code === 'WIZ')
                                    <img src="{{ asset('images/logos/wizall money.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'COR')
                                    <img src="{{ asset('images/logos/coris money.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'OM')
                                    <img src="{{ asset('images/logos/orange money.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'MM')
                                    <img src="{{ asset('images/logos/moov money.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'TM')
                                    <img src="{{ asset('images/logos/telecel money.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'WU')
                                    <img src="{{ asset('images/logos/western union.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'RIA')
                                    <img src="{{ asset('images/logos/RIA.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'MGNK')
                                    <img src="{{ asset('images/logos/moneyGram.png') }}" alt="{{ $service->name }}">
                                @elseif($service->code === 'WUNK')
                                    <img src="{{ asset('images/logos/western union.png') }}" alt="{{ $service->name }}">
                                @else
                                    <i class="fas fa-exchange-alt"></i>
                                @endif
                            </div>
                            <div>
                                <h2>{{ $service->name }}</h2>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Operation Types -->
                    <div class="operation-types">
                        <h4><i class="fas fa-cogs me-2"></i>Types d'opérations disponibles</h4>
                        <div class="row">
                            @foreach($operationTypes as $operationType)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <a href="{{ route('caissier.transactions.create', ['service' => $service->code, 'operation_type' => $operationType->code]) }}" class="text-decoration-none">
                                    <div class="operation-card">
                                        <div class="operation-icon">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <h5>{{ $operationType->name }}</h5>
                                        <p class="text-muted">{{ $operationType->description }}</p>
                                    </div>
                                </a>
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
