<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres | Askya Finance</title>
    
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

        /* Settings Card */
        .settings-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            max-width: 900px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }

        .section-title i {
            color: var(--primary-blue);
            margin-right: 10px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(248, 113, 113, 0.15) 100%);
            color: var(--danger);
        }

        /* Switch */
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
            cursor: pointer;
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

            .settings-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container-fluid">
            <div class="header-brand">
                <i class="fas fa-coins"></i>
                <span>Askya Finance</span>
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
                    Gestion des utilisateurs
                </a>
            </li>
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
                <a href="{{ route('admin.settings.index') }}" class="active">
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
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h1><i class="fas fa-cog me-2"></i>Paramètres</h1>
                <p>Gérez les paramètres de la plateforme</p>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="settings-card">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Informations de l'entreprise -->
                <h3 class="section-title">
                    <i class="fas fa-building"></i>
                    Informations de l'entreprise
                </h3>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="entreprise_nom" class="form-label">Nom de l'entreprise</label>
                        <input type="text" class="form-control" id="entreprise_nom" name="entreprise_nom" value="{{ $settings['entreprise_nom'] }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="entreprise_telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="entreprise_telephone" name="entreprise_telephone" value="{{ $settings['entreprise_telephone'] }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="entreprise_adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="entreprise_adresse" name="entreprise_adresse" value="{{ $settings['entreprise_adresse'] }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="entreprise_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="entreprise_email" name="entreprise_email" value="{{ $settings['entreprise_email'] }}">
                    </div>
                </div>

                <!-- Sécurité -->
                <h3 class="section-title">
                    <i class="fas fa-shield-alt"></i>
                    Sécurité
                </h3>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Laisser vide si pas de changement">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Laisser vide si pas de changement">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirmez le mot de passe">
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="double_auth" name="double_auth" {{ $settings['double_auth'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="double_auth">Activer la double authentification</label>
                        </div>
                    </div>
                </div>

                <!-- Préférences -->
                <h3 class="section-title">
                    <i class="fas fa-sliders-h"></i>
                    Préférences
                </h3>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label for="langue" class="form-label">Langue</label>
                        <select class="form-select" id="langue" name="langue" required>
                            <option value="fr" {{ $settings['langue'] == 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ $settings['langue'] == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fuseau_horaire" class="form-label">Fuseau horaire</label>
                        <select class="form-select" id="fuseau_horaire" name="fuseau_horaire" required>
                            <option value="Africa/Abidjan" {{ $settings['fuseau_horaire'] == 'Africa/Abidjan' ? 'selected' : '' }}>Africa/Abidjan</option>
                            <option value="Africa/Dakar" {{ $settings['fuseau_horaire'] == 'Africa/Dakar' ? 'selected' : '' }}>Africa/Dakar</option>
                            <option value="Africa/Lagos" {{ $settings['fuseau_horaire'] == 'Africa/Lagos' ? 'selected' : '' }}>Africa/Lagos</option>
                            <option value="Europe/Paris" {{ $settings['fuseau_horaire'] == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="devise" class="form-label">Devise</label>
                        <select class="form-select" id="devise" name="devise" required>
                            <option value="XOF" {{ $settings['devise'] == 'XOF' ? 'selected' : '' }}>XOF (FCFA)</option>
                            <option value="EUR" {{ $settings['devise'] == 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                            <option value="USD" {{ $settings['devise'] == 'USD' ? 'selected' : '' }}>USD (Dollar)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
