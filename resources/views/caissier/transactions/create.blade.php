@extends('layouts.dashboard')

@section('title', 'Nouvelle Transaction')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('caissier.transactions.index') }}" class="text-primary text-decoration-none">Transactions</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Nouvelle transaction</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1>Nouvelle transaction</h1>
        <p>Enregistrez une transaction financière de dépôt, retrait, transfert ou paiement.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 1000px;">
    <form action="{{ route('caissier.transactions.store') }}" method="POST" enctype="multipart/form-data" id="transactionForm">
        @csrf

        <!-- SECTION 1 : Informations du client -->
        <div class="pb-4 mb-4" style="border-bottom: 1px solid var(--border-glass);">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-user text-primary"></i>
                <span>Informations du client</span>
            </h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="client_name" class="form-label-custom">Nom complet du client *</label>
                    <input type="text" class="form-control-custom @error('client_name') is-invalid @enderror" 
                           id="client_name" name="client_name" required 
                           placeholder="Ex: Jean Dupont"
                           value="{{ old('client_name') }}">
                    @error('client_name')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="client_phone" class="form-label-custom">Numéro de téléphone</label>
                    <input type="text" class="form-control-custom @error('client_phone') is-invalid @enderror" 
                           id="client_phone" name="client_phone" 
                           placeholder="Ex: +226 70 00 00 00"
                           value="{{ old('client_phone') }}">
                    @error('client_phone')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="client_id_number" class="form-label-custom">Numéro de pièce d'identité</label>
                    <input type="text" class="form-control-custom @error('client_id_number') is-invalid @enderror" 
                           id="client_id_number" name="client_id_number" 
                           placeholder="Ex: B1234567"
                           value="{{ old('client_id_number') }}">
                    @error('client_id_number')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2 : Informations de la transaction -->
        <div class="pb-4 mb-4" style="border-bottom: 1px solid var(--border-glass);">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-exchange-alt text-primary"></i>
                <span>Détails financiers de l'opération</span>
            </h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="type" class="form-label-custom">Type de transaction *</label>
                    <select class="form-control-custom form-select-custom @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="">Sélectionnez le type</option>
                        <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Dépôt</option>
                        <option value="withdraw" {{ old('type') == 'withdraw' ? 'selected' : '' }}>Retrait</option>
                        <option value="transfer" {{ old('type') == 'transfer' ? 'selected' : '' }}>Transfert</option>
                        <option value="payment" {{ old('type') == 'payment' ? 'selected' : '' }}>Paiement</option>
                    </select>
                    @error('type')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="service_id" class="form-label-custom">Service financier *</label>
                    <select class="form-control-custom form-select-custom @error('service_id') is-invalid @enderror" 
                            id="service_id" name="service_id" required onchange="loadOperationTypes()">
                        <option value="">Sélectionnez le service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $selectedService && $selectedService->id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('service_id')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="operation_type_id" class="form-label-custom">Type d'opération *</label>
                    <select class="form-control-custom form-select-custom @error('operation_type_id') is-invalid @enderror" 
                            id="operation_type_id" name="operation_type_id" required>
                        <option value="">Sélectionnez d'abord le service</option>
                        @foreach($operationTypes as $operationType)
                        <option value="{{ $operationType->id }}" {{ $selectedOperationType && $selectedOperationType->id == $operationType->id ? 'selected' : '' }}>
                            {{ $operationType->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('operation_type_id')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row g-4 mt-1">
                <div class="col-md-6">
                    <label for="transaction_date" class="form-label-custom">Date *</label>
                    <input type="date" class="form-control-custom @error('transaction_date') is-invalid @enderror" 
                           id="transaction_date" name="transaction_date" required
                           value="{{ old('transaction_date') ?? \Carbon\Carbon::today()->format('Y-m-d') }}">
                    @error('transaction_date')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="transaction_time" class="form-label-custom">Heure *</label>
                    <input type="time" class="form-control-custom @error('transaction_time') is-invalid @enderror" 
                           id="transaction_time" name="transaction_time" required
                           value="{{ old('transaction_time') ?? \Carbon\Carbon::now()->format('H:i') }}">
                    @error('transaction_time')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-4">
                    <label for="amount" class="form-label-custom">Montant net (FCFA) *</label>
                    <input type="number" class="form-control-custom @error('amount') is-invalid @enderror" 
                           id="amount" name="amount" required min="100" step="50"
                           placeholder="Montant en FCFA"
                           value="{{ old('amount') }}"
                           oninput="calculerTotal()">
                    @error('amount')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="fees" class="form-label-custom">Frais de service (FCFA) *</label>
                    <input type="number" class="form-control-custom @error('fees') is-invalid @enderror" 
                           id="fees" name="fees" required min="0" step="25"
                           placeholder="Frais en FCFA"
                           value="{{ old('fees') ?? 0 }}"
                           oninput="calculerTotal()">
                    @error('fees')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="commission" class="form-label-custom">Commission (FCFA)</label>
                    <input type="number" class="form-control-custom @error('commission') is-invalid @enderror" 
                           id="commission" name="commission" min="0" step="25"
                           placeholder="Commission éventuelle"
                           value="{{ old('commission') }}">
                    @error('commission')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-6">
                    <label for="total" class="form-label-custom">Montant total brut (FCFA)</label>
                    <input type="number" class="form-control-custom" 
                           id="total" name="total" readonly
                           placeholder="Calculé automatiquement" style="background: rgba(255,255,255,0.05) !important;">
                </div>

                <div class="col-md-6">
                    <label for="notes" class="form-label-custom">Notes / Observations</label>
                    <textarea class="form-control-custom @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="1"
                              placeholder="Notes ou détails supplémentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-12">
                    <label for="receipt" class="form-label-custom">📎 Téléverser le reçu de l'opération (PDF, Images - Max 5 Mo)</label>
                    <input type="file" class="form-control-custom @error('receipt') is-invalid @enderror" 
                           id="receipt" name="receipt" accept=".pdf,.jpg,.jpeg,.png,.webp,image/*">
                    @error('receipt')
                    <div class="text-danger mt-2 small"><i class="fas fa-circle-exclamation me-1"></i> {{ $message }}</div>
                    @enderror
                    <div class="text-muted small mt-2">Le document sera chiffré et stocké en toute sécurité.</div>
                </div>
            </div>
        </div>

        <!-- SECTION 3 : Informations système masquées mais visibles en lecture seule -->
        <div class="pb-4 mb-4" style="border-bottom: 1px solid var(--border-glass);">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-cog text-primary"></i>
                <span>Données système</span>
            </h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label-custom">Numéro de transaction généré</label>
                    <input type="text" class="form-control-custom" readonly
                           value="TRX-{{ date('Y') }}-{{ str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}" style="background: rgba(255,255,255,0.03) !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Caissier assigné</label>
                    <input type="text" class="form-control-custom" readonly
                           value="{{ Auth::user()->name }}" style="background: rgba(255,255,255,0.03) !important;">
                </div>
            </div>
        </div>

        <!-- SECTION 4 : Récapitulatif dynamique -->
        <div class="pb-4 mb-5">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-clipboard-list text-primary"></i>
                <span>Récapitulatif en temps réel</span>
            </h5>
            
            <div class="p-4 rounded-4" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%); border: 1px solid rgba(59, 130, 246, 0.15);">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Client</span>
                    <span class="text-white fw-bold" id="summary_client">-</span>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Téléphone</span>
                    <span class="text-white" id="summary_telephone">-</span>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Type d'opération</span>
                    <span class="text-white fw-semibold" id="summary_type">-</span>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Service financier</span>
                    <span class="text-white fw-semibold" id="summary_service">-</span>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Montant net</span>
                    <span class="text-white" id="summary_amount">-</span>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                    <span class="text-muted small fw-bold">Frais de service</span>
                    <span class="text-white" id="summary_fees">-</span>
                </div>
                <div class="d-flex justify-content-between py-3">
                    <span class="text-white fw-bold">MONTANT TOTAL</span>
                    <span class="text-primary fw-extrabold fs-5" id="summary_total">-</span>
                </div>
            </div>
        </div>

        <!-- Boutons d'actions -->
        <div class="d-flex flex-wrap gap-3">
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <i class="fas fa-save"></i> Enregistrer la transaction
            </button>
            <button type="button" class="btn-custom btn-custom-danger px-4 py-2.5" onclick="resetForm()">
                <i class="fas fa-arrow-rotate-left"></i> Réinitialiser
            </button>
            <a href="{{ route('caissier.transactions.index') }}" class="btn-custom px-4 py-2.5 text-decoration-none">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Calcul automatique du total
    function calculerTotal() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const fees = parseFloat(document.getElementById('fees').value) || 0;
        const total = amount + fees;
        
        document.getElementById('total').value = total;
    }

    // Charger dynamiquement les types d'opération en AJAX
    function loadOperationTypes() {
        const serviceId = document.getElementById('service_id').value;
        const operationTypeSelect = document.getElementById('operation_type_id');
        
        if (!serviceId) {
            operationTypeSelect.innerHTML = '<option value="">Sélectionnez d\'abord le service</option>';
            return;
        }
        
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

    // Formater l'affichage monétaire
    function formatMoney(amount) {
        return amount.toLocaleString('fr-FR') + ' FCFA';
    }

    // Mettre à jour les résumés textuels en temps réel
    function updateSummary() {
        const clientName = document.getElementById('client_name').value;
        const clientPhone = document.getElementById('client_phone').value;
        const typeSelect = document.getElementById('type');
        const serviceSelect = document.getElementById('service_id');
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const fees = parseFloat(document.getElementById('fees').value) || 0;
        const total = amount + fees;

        document.getElementById('summary_client').textContent = clientName || '-';
        document.getElementById('summary_telephone').textContent = clientPhone || '-';
        
        document.getElementById('summary_type').textContent = typeSelect.selectedIndex > 0 ? typeSelect.options[typeSelect.selectedIndex].text : '-';
        document.getElementById('summary_service').textContent = serviceSelect.selectedIndex > 0 ? serviceSelect.options[serviceSelect.selectedIndex].text : '-';
        
        document.getElementById('summary_amount').textContent = amount > 0 ? formatMoney(amount) : '-';
        document.getElementById('summary_fees').textContent = fees > 0 ? formatMoney(fees) : '-';
        document.getElementById('summary_total').textContent = total > 0 ? formatMoney(total) : '-';
    }

    // Réinitialiser le formulaire proprement
    function resetForm() {
        document.getElementById('transactionForm').reset();
        document.getElementById('total').value = '';
        
        document.getElementById('summary_client').textContent = '-';
        document.getElementById('summary_telephone').textContent = '-';
        document.getElementById('summary_type').textContent = '-';
        document.getElementById('summary_service').textContent = '-';
        document.getElementById('summary_amount').textContent = '-';
        document.getElementById('summary_fees').textContent = '-';
        document.getElementById('summary_total').textContent = '-';
    }

    // Lier les écouteurs de modification
    document.addEventListener('DOMContentLoaded', function() {
        const fields = ['client_name', 'client_phone', 'type', 'service_id', 'amount', 'fees'];
        fields.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', updateSummary);
                el.addEventListener('change', updateSummary);
            }
        });
        
        // Initialiser si nécessaire
        updateSummary();
    });
</script>
@endsection
