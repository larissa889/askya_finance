<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import historique | Askya Finance</title>
    
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

        /* Import Card */
        .import-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            max-width: 800px;
            margin: 0 auto;
        }

        .import-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--text-dark);
        }

        .alert-info {
            background: rgba(6, 182, 212, 0.1);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: var(--info);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
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

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
                        <div class="role">Administrateur</div>
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
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    Utilisateurs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    Rapports
                </a>
            </li>
            <li>
                <a href="{{ route('admin.historical-import.index') }}" class="active">
                    <i class="fas fa-history"></i>
                    Import historique
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog"></i>
                    Paramètres
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-history me-2"></i>Import des transactions historiques</h2>
            <a href="{{ route('admin.historical-import.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>

        <div class="import-card">
            <h4><i class="fas fa-file-upload me-2"></i>Importer les transactions</h4>
            
            <div class="alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Important:</strong> L'import des transactions historiques n'affectera pas les données de production actuelles. Les transactions importées seront marquées comme historiques et généreront automatiquement les clôtures de caisse correspondantes.
            </div>

            <form action="{{ route('admin.historical-import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="agency_id" class="form-label">Agence *</label>
                    <select class="form-select @error('agency_id') is-invalid @enderror" 
                            id="agency_id" name="agency_id" required>
                        <option value="">Sélectionnez l'agence</option>
                        @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                            {{ $agency->name }} ({{ $agency->code }})
                        </option>
                        @endforeach
                    </select>
                    @error('agency_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="import_file" class="form-label">Fichier d'import (Excel/CSV) *</label>
                    <input type="file" class="form-control @error('import_file') is-invalid @enderror" 
                           id="import_file" name="import_file" required
                           accept=".xlsx,.xls,.csv">
                    <div class="form-text">Formats acceptés: XLSX, XLS, CSV</div>
                    @error('import_file')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Date de début *</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" name="start_date" required
                               value="{{ old('start_date') }}">
                        @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Date de fin *</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               id="end_date" name="end_date" required
                               value="{{ old('end_date') }}">
                        @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Format du fichier attendu:</strong><br>
                    Le fichier doit contenir les colonnes suivantes: client_name, client_phone, service, operation_type, amount, fees, currency, transaction_date, transaction_time, observations
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.historical-import.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Importer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
