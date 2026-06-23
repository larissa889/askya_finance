<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'arrêt | Askya Finance</title>
    
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
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            padding: 30px;
            margin-top: 70px;
        }

        /* Header Section */
        .header-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 20px;
        }

        /* Balance Cards */
        .balance-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .balance-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .balance-card h3 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .balance-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .balance-row:last-child {
            border-bottom: none;
        }

        .balance-label {
            font-weight: 500;
            color: var(--dark-text);
        }

        .balance-value {
            font-weight: 600;
            color: var(--dark-text);
        }

        .balance-value.final {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        /* Transactions Table */
        .transactions-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .transactions-section h3 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-receipt {
            padding: 5px 10px;
            font-size: 0.85rem;
            margin-right: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .balance-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('caissier.dashboard') }}">
                <i class="fas fa-wallet"></i>ASKYA Finance
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('caissier.dashboard') }}">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('caissier.transactions.index') }}">
                            <i class="fas fa-list me-2"></i>Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('caissier.end-of-day.index') }}">
                            <i class="fas fa-file-alt me-2"></i>Fiche d'arrêt
                        </a>
                    </li>
                </ul>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-white fw-bold">{{ Auth::user()->name }}</div>
                        <div class="text-white-50 small">{{ Auth::user()->agency->name ?? 'Non assigné' }}</div>
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="company-name">ASKYA Finance</div>
                    <div class="report-title">Fiche d'arrêt</div>
                    <div class="text-muted">
                        <i class="fas fa-calendar me-2"></i>
                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                    </div>
                </div>
                <div>
                    <a href="{{ route('caissier.end-of-day.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d']) }}" 
                       class="btn btn-outline-primary me-2">
                        <i class="fas fa-chevron-left me-2"></i>Jour précédent
                    </a>
                    @if($date != \Carbon\Carbon::today()->format('Y-m-d'))
                    <a href="{{ route('caissier.end-of-day.index', ['date' => \Carbon\Carbon::today()->format('Y-m-d')]) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-calendar-day me-2"></i>Aujourd'hui
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Balance Section -->
        <div class="balance-section">
            <!-- Situation Compte -->
            <div class="balance-card">
                <h3>Situation Compte</h3>
                <form id="endOfDayForm" action="{{ route('caissier.end-of-day.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    <input type="hidden" name="cash_register_id" value="{{ $cashRegister->id }}">
                    <input type="hidden" name="approvisionnement_compte" value="{{ $approvisionnementCompte }}">
                    <input type="hidden" name="paiements_compte" value="{{ $paiementsCompte }}">
                    <input type="hidden" name="depots_clients_compte" value="{{ $depotsClientsCompte }}">
                    <input type="hidden" name="sorties_compte" value="{{ $sortiesCompte }}">
                    
                    <div class="balance-row">
                        <span class="balance-label">Solde initial</span>
                        <span class="balance-value">{{ number_format($soldeInitialCompte, 0, ',', ' ') }} FCFA</span>
                        <input type="hidden" name="solde_initial_compte" value="{{ $soldeInitialCompte }}">
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Approvisionnement</span>
                        <span class="balance-value">{{ number_format($approvisionnementCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Paiements</span>
                        <span class="balance-value">-{{ number_format($paiementsCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Dépôts clients</span>
                        <span class="balance-value">+{{ number_format($depotsClientsCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Sorties</span>
                        <span class="balance-value">-{{ number_format($sortiesCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Solde final théorique</span>
                        <span class="balance-value">{{ number_format($soldeFinalCompte, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Solde final réel</span>
                        <input type="number" class="form-control form-control-sm" style="width: 150px; text-align: right;" 
                               name="solde_final_compte" value="{{ $history ? $history->solde_final_compte : $soldeFinalCompte }}" 
                               onchange="calculerEcartCompte()">
                    </div>
                    <div class="balance-row">
                        <span class="balance-label">Écart</span>
                        <span class="balance-value" id="ecartCompteValue">{{ number_format($ecartCompte, 0, ',', ' ') }} FCFA</span>
                        <input type="hidden" name="ecart_compte" id="ecartCompteInput" value="{{ $ecartCompte }}">
                    </div>
                </form>
            </div>

            <!-- Situation Caisse -->
            <div class="balance-card">
                <h3>Situation Caisse</h3>
                <div class="balance-row">
                    <span class="balance-label">Solde initial</span>
                    <span class="balance-value">{{ number_format($soldeInitialCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="solde_initial_caisse" value="{{ $soldeInitialCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Approvisionnement</span>
                    <span class="balance-value">{{ number_format($approvisionnementCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="approvisionnement_caisse" value="{{ $approvisionnementCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Dépôts clients</span>
                    <span class="balance-value">+{{ number_format($depotsClientsCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="depots_clients_caisse" value="{{ $depotsClientsCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Paiements</span>
                    <span class="balance-value">-{{ number_format($paiementsCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="paiements_caisse" value="{{ $paiementsCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Sorties</span>
                    <span class="balance-value">-{{ number_format($sortiesCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="sorties_caisse" value="{{ $sortiesCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Solde final théorique</span>
                    <span class="balance-value">{{ number_format($soldeFinalCaisse, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="balance-row">
                    <span class="balance-label">Solde final réel</span>
                    <input type="number" class="form-control form-control-sm" style="width: 150px; text-align: right;" 
                           name="solde_final_caisse" value="{{ $history ? $history->solde_final_caisse : $soldeFinalCaisse }}" 
                           onchange="calculerEcartCaisse()">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Écart de caisse</span>
                    <span class="balance-value" id="ecartCaisseValue">{{ number_format($ecartCaisse, 0, ',', ' ') }} FCFA</span>
                    <input type="hidden" name="ecart_caisse" id="ecartCaisseInput" value="{{ $ecartCaisse }}">
                </div>
                <div class="balance-row">
                    <span class="balance-label">Nombre de transactions</span>
                    <span class="balance-value">{{ $nombreTransactions }}</span>
                    <input type="hidden" name="nombre_transactions" value="{{ $nombreTransactions }}">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="text-center mb-4">
            <button type="submit" form="endOfDayForm" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Enregistrer la fiche d'arrêt
            </button>
        </div>

        <!-- Transactions Section -->
        <div class="transactions-section">
            <h3>Transactions du jour</h3>
            @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Service</th>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Heure</th>
                            <th>Reçu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction->reference }}</strong></td>
                            <td>{{ $transaction->service->name }}</td>
                            <td>{{ $transaction->client_name }}</td>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $transaction->transaction_date ? $transaction->transaction_date->format('H:i') : $transaction->created_at->format('H:i') }}</td>
                            <td>
                                @if($transaction->receipt_path)
                                <a href="{{ asset($transaction->receipt_path) }}" target="_blank" 
                                   class="btn btn-sm btn-primary btn-receipt" title="Voir le reçu">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset($transaction->receipt_path) }}" download 
                                   class="btn btn-sm btn-secondary btn-receipt" title="Télécharger le reçu">
                                    <i class="fas fa-download"></i>
                                </a>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune transaction pour cette date</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Solde final théorique
        const soldeFinalCompteTheorique = {{ $soldeFinalCompte }};
        const soldeFinalCaisseTheorique = {{ $soldeFinalCaisse }};

        function calculerEcartCompte() {
            const soldeReel = parseFloat(document.querySelector('input[name="solde_final_compte"]').value) || 0;
            const ecart = soldeReel - soldeFinalCompteTheorique;
            document.getElementById('ecartCompteValue').textContent = ecart.toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('ecartCompteInput').value = ecart;
        }

        function calculerEcartCaisse() {
            const soldeReel = parseFloat(document.querySelector('input[name="solde_final_caisse"]').value) || 0;
            const ecart = soldeReel - soldeFinalCaisseTheorique;
            document.getElementById('ecartCaisseValue').textContent = ecart.toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('ecartCaisseInput').value = ecart;
        }
    </script>
</body>
</html>
