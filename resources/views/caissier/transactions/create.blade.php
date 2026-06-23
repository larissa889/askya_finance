<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle transaction | Askya Finance</title>
    
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

        /* Form Card */
        .form-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            max-width: 1000px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary-blue);
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

        .form-control:disabled,
        .form-select:disabled {
            background-color: var(--light-gray);
            cursor: not-allowed;
        }

        .text-danger {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Summary Card */
        .summary-card {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
            border: 1px solid rgba(37, 99, 235, 0.2);
            border-radius: 12px;
            padding: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .summary-value {
            color: var(--text-dark);
            font-weight: 600;
        }

        .summary-value.total {
            color: var(--primary-blue);
            font-size: 1.3rem;
            font-weight: 700;
        }

        /* Buttons */
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-reset {
            background: var(--warning);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: var(--light-gray);
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

            .form-card {
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
                <a href="{{ route('caissier.transactions.index') }}">
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
                    <li class="breadcrumb-item active" aria-current="page">Nouvelle transaction</li>
                </ol>
            </nav>
            <div class="page-title">
                <h1><i class="fas fa-plus-circle me-2"></i>Nouvelle transaction</h1>
                <p>Créez une nouvelle transaction</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <form action="{{ route('caissier.transactions.store') }}" method="POST" enctype="multipart/form-data" id="transactionForm">
                @csrf

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <!-- SECTION 1 : Informations du client -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Informations du client
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Nom complet du client *</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" required 
                                   placeholder="Entrez le nom complet du client"
                                   value="{{ old('client_name') }}">
                            @error('client_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="client_phone" class="form-label">Numéro de téléphone</label>
                            <input type="text" class="form-control @error('client_phone') is-invalid @enderror" 
                                   id="client_phone" name="client_phone" 
                                   placeholder="+225 07 00 00 00 00"
                                   value="{{ old('client_phone') }}">
                            @error('client_phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_id_number" class="form-label">Numéro de pièce d'identité</label>
                            <input type="text" class="form-control @error('client_id_number') is-invalid @enderror" 
                                   id="client_id_number" name="client_id_number" 
                                   placeholder="Entrez le numéro de la pièce"
                                   value="{{ old('client_id_number') }}">
                            @error('client_id_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 : Informations de la transaction -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-exchange-alt"></i>
                        Informations de la transaction
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type de transaction *</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Sélectionnez le type</option>
                                <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Dépôt</option>
                                <option value="withdraw" {{ old('type') == 'withdraw' ? 'selected' : '' }}>Retrait</option>
                                <option value="transfer" {{ old('type') == 'transfer' ? 'selected' : '' }}>Transfert</option>
                                <option value="payment" {{ old('type') == 'payment' ? 'selected' : '' }}>Paiement</option>
                            </select>
                            @error('type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service_id" class="form-label">Service *</label>
                            <select class="form-select @error('service_id') is-invalid @enderror" 
                                    id="service_id" name="service_id" required onchange="loadOperationTypes()">
                                <option value="">Sélectionnez le service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $selectedService && $selectedService->id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('service_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="operation_type_id" class="form-label">Type d'opération *</label>
                            <select class="form-select @error('operation_type_id') is-invalid @enderror" 
                                    id="operation_type_id" name="operation_type_id" required>
                                <option value="">Sélectionnez d'abord le service</option>
                                @foreach($operationTypes as $operationType)
                                <option value="{{ $operationType->id }}" {{ $selectedOperationType && $selectedOperationType->id == $operationType->id ? 'selected' : '' }}>
                                    {{ $operationType->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('operation_type_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="transaction_date" class="form-label">Date de la transaction *</label>
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                   id="transaction_date" name="transaction_date" required
                                   value="{{ old('transaction_date') ?? \Carbon\Carbon::today()->format('Y-m-d') }}">
                            @error('transaction_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transaction_time" class="form-label">Heure de la transaction *</label>
                            <input type="time" class="form-control @error('transaction_time') is-invalid @enderror" 
                                   id="transaction_time" name="transaction_time" required
                                   value="{{ old('transaction_time') ?? \Carbon\Carbon::now()->format('H:i') }}">
                            @error('transaction_time')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="amount" class="form-label">Montant (FCFA) *</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" required min="1000" step="100"
                                   placeholder="Entrez le montant"
                                   value="{{ old('amount') }}"
                                   oninput="calculerTotal()">
                            @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fees" class="form-label">Frais (FCFA) *</label>
                            <input type="number" class="form-control @error('fees') is-invalid @enderror" 
                                   id="fees" name="fees" required min="0" step="100"
                                   placeholder="Entrez les frais"
                                   value="{{ old('fees') ?? 0 }}"
                                   oninput="calculerTotal()">
                            @error('fees')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="commission" class="form-label">Commission (FCFA)</label>
                            <input type="number" class="form-control @error('commission') is-invalid @enderror" 
                                   id="commission" name="commission" min="0" step="100"
                                   placeholder="Commission (si applicable)"
                                   value="{{ old('commission') }}">
                            @error('commission')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="total" class="form-label">Montant total (FCFA)</label>
                            <input type="number" class="form-control" 
                                   id="total" name="total" readonly
                                   placeholder="Calculé automatiquement">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="notes" class="form-label">Observations</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="1"
                                      placeholder="Observations supplémentaires (optionnel)">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="receipt" class="form-label">📎 Joindre le reçu (PDF, JPG, JPEG, PNG - Max 5MB)</label>
                            <input type="file" class="form-control @error('receipt') is-invalid @enderror" 
                                   id="receipt" name="receipt" accept=".pdf,.jpg,.jpeg,.png,.webp,image/*">
                            @error('receipt')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Le reçu sera stocké de manière sécurisée et associé à cette transaction.</small>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3 : Informations système -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-cog"></i>
                        Informations système
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="numero_transaction" class="form-label">Numéro de transaction</label>
                            <input type="text" class="form-control" 
                                   id="numero_transaction" name="numero_transaction" readonly
                                   value="TRX-{{ date('Y') }}-{{ str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_transaction" class="form-label">Date et heure</label>
                            <input type="text" class="form-control" 
                                   id="date_transaction" name="date_transaction" readonly
                                   value="{{ date('d/m/Y H:i') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="caissier" class="form-label">Caissier</label>
                            <input type="text" class="form-control" 
                                   id="caissier" name="caissier" readonly
                                   value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <input type="text" class="form-control" 
                                   id="statut" name="statut" readonly
                                   value="En attente">
                        </div>
                    </div>
                </div>

                <!-- SECTION 4 : Récapitulatif -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-clipboard-list"></i>
                        Récapitulatif
                    </h3>
                    <div class="summary-card">
                        <div class="summary-row">
                            <span class="summary-label">Client</span>
                            <span class="summary-value" id="summary_client">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Téléphone</span>
                            <span class="summary-value" id="summary_telephone">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Type de transaction</span>
                            <span class="summary-value" id="summary_type">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Service</span>
                            <span class="summary-value" id="summary_service">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Montant</span>
                            <span class="summary-value" id="summary_montant">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Frais</span>
                            <span class="summary-value" id="summary_frais">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Total</span>
                            <span class="summary-value total" id="summary_total">-</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Date</span>
                            <span class="summary-value">{{ date('d/m/Y H:i') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Caissier</span>
                            <span class="summary-value">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Enregistrer la transaction
                    </button>
                    <button type="button" class="btn btn-reset" onclick="resetForm()">
                        <i class="fas fa-redo me-2"></i>Réinitialiser
                    </button>
                    <a href="{{ route('caissier.transactions.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript pour le calcul automatique et le récapitulatif -->
    <script>
        // Calculer le montant total
        function calculerTotal() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const fees = parseFloat(document.getElementById('fees').value) || 0;
            const total = amount + fees;
            
            document.getElementById('total').value = total;
        }

        // Charger les types d'opérations pour un service
        function loadOperationTypes() {
            const serviceId = document.getElementById('service_id').value;
            const operationTypeSelect = document.getElementById('operation_type_id');
            
            if (!serviceId) {
                operationTypeSelect.innerHTML = '<option value="">Sélectionnez d\'abord le service</option>';
                return;
            }
            
            // Charger les types d'opérations via AJAX
            fetch(`/caissier/services/${serviceId}/operation-types`)
                .then(response => response.json())
                .then(data => {
                    operationTypeSelect.innerHTML = '<option value="">Sélectionnez le type d\'opération</option>';
                    data.forEach(operationType => {
                        operationTypeSelect.innerHTML += `<option value="${operationType.id}">${operationType.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des types d\'opérations:', error);
                });
        }

        // Mettre à jour le récapitulatif en temps réel
        function updateSummary() {
            const clientNom = document.getElementById('client_nom').value;
            const clientTelephone = document.getElementById('client_telephone').value;
            const typeTransaction = document.getElementById('type_transaction');
            const serviceTransfert = document.getElementById('service_transfert');
            const montant = parseFloat(document.getElementById('montant').value) || 0;
            const frais = parseFloat(document.getElementById('frais').value) || 0;
            const total = montant + frais;

            document.getElementById('summary_client').textContent = clientNom || '-';
            document.getElementById('summary_telephone').textContent = clientTelephone || '-';
            document.getElementById('summary_type').textContent = typeTransaction.options[typeTransaction.selectedIndex].text || '-';
            document.getElementById('summary_service').textContent = serviceTransfert.options[serviceTransfert.selectedIndex].text || '-';
            document.getElementById('summary_montant').textContent = montant > 0 ? number_format(montant) + ' FCFA' : '-';
            document.getElementById('summary_frais').textContent = frais > 0 ? number_format(frais) + ' FCFA' : '-';
            document.getElementById('summary_total').textContent = total > 0 ? number_format(total) + ' FCFA' : '-';
        }

        // Formater les nombres
        function number_format(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        // Réinitialiser le formulaire
        function resetForm() {
            document.getElementById('transactionForm').reset();
            document.getElementById('montant_total').value = '';
            
            // Régénérer un nouveau numéro de transaction
            const year = new Date().getFullYear();
            const random = Math.floor(Math.random() * 9999) + 1;
            document.getElementById('numero_transaction').value = 'TRX-' + year + '-' + random.toString().padStart(4, '0');
            
            // Réinitialiser la date
            const now = new Date();
            const dateStr = now.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + 
                          now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('date_transaction').value = dateStr;
            
            // Réinitialiser le récapitulatif
            document.getElementById('summary_client').textContent = '-';
            document.getElementById('summary_telephone').textContent = '-';
            document.getElementById('summary_type').textContent = '-';
            document.getElementById('summary_service').textContent = '-';
            document.getElementById('summary_montant').textContent = '-';
            document.getElementById('summary_frais').textContent = '-';
            document.getElementById('summary_total').textContent = '-';
        }

        // Écouteurs d'événements pour la mise à jour en temps réel
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = ['client_nom', 'client_telephone', 'type_transaction', 'service_transfert', 'montant', 'frais'];
            
            inputs.forEach(function(id) {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateSummary);
                    element.addEventListener('change', updateSummary);
                }
            });
        });
    </script>
</body>
</html>
