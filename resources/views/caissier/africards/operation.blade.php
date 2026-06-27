@extends('layouts.dashboard')

@section('title', $type === 'deposit' ? 'Dépôt Africards' : 'Retrait Africards')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('caissier.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $type === 'deposit' ? 'Dépôt' : 'Retrait' }} Africards</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>{{ $type === 'deposit' ? 'Dépôt' : 'Retrait' }} Africards</h1>
            <p>Enregistrez une transaction sur une carte Africards client.</p>
        </div>
        <a href="{{ route('caissier.dashboard') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <form action="{{ route('caissier.africards.operation.store') }}" method="POST" class="d-flex flex-column gap-4" id="africardsOpForm">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="row g-3">
            <div class="col-md-12">
                <label for="card_number" class="form-label-custom">Sélectionnez la carte Africards *</label>
                <select class="form-control form-control-custom form-select-custom @error('card_number') is-invalid @enderror" 
                        id="card_number" name="card_number" required>
                    <option value="">Sélectionnez un compte...</option>
                    @foreach($accounts as $acc)
                    <option value="{{ $acc->card_number }}" {{ old('card_number') == $acc->card_number ? 'selected' : '' }}>
                        {{ $acc->card_number }} - {{ $acc->client_name }} (Solde: {{ number_format($acc->balance, 0, ',', ' ') }} FCFA)
                    </option>
                    @endforeach
                </select>
                @error('card_number')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="amount" class="form-label-custom">Montant net (FCFA) *</label>
                <input type="number" class="form-control form-control-custom @error('amount') is-invalid @enderror" 
                       id="amount" name="amount" required min="1000" step="100" value="{{ old('amount') }}" oninput="calculerTotal()">
                @error('amount')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="fees" class="form-label-custom">Frais de l'opération (FCFA) *</label>
                <input type="number" class="form-control form-control-custom @error('fees') is-invalid @enderror" 
                       id="fees" name="fees" required min="0" value="{{ old('fees') ?? 0 }}" oninput="calculerTotal()">
                @error('fees')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <label for="total" class="form-label-custom">Montant Brut / Facturé (FCFA)</label>
                <input type="text" class="form-control form-control-custom" id="total" readonly placeholder="Calculé automatiquement" style="background: rgba(255,255,255,0.03) !important;">
            </div>
        </div>

        <!-- Dynamic commissions preview (calcul automatique de la part d'Askya, de la part de la banque, et du montant net) -->
        <div class="row g-3">
            <div class="col-md-12">
                <div class="p-3 rounded-4" style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.15);">
                    <h6 class="text-white fw-bold mb-3"><i class="fas fa-calculator text-primary me-2"></i>Répartition des commissions</h6>
                    <div class="d-flex justify-content-between py-1 small border-bottom border-light border-opacity-10">
                        <span class="text-muted">Part Askya Finances (60% des frais) :</span>
                        <span class="text-white fw-bold" id="askya_part">0 FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between py-1 small border-bottom border-light border-opacity-10">
                        <span class="text-muted">Part de la Banque UBA (40% des frais) :</span>
                        <span class="text-white fw-bold" id="bank_part">0 FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span class="text-muted fw-bold">Montant Net :</span>
                        <span class="text-primary fw-extrabold" id="net_part">0 FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <label for="notes" class="form-label-custom">Notes / Observations</label>
                <textarea class="form-control form-control-custom @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3" placeholder="Notes supplémentaires...">{{ old('notes') }}</textarea>
                @error('notes')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <i class="fas fa-save"></i> Enregistrer l'opération
            </button>
            <a href="{{ route('caissier.dashboard') }}" class="btn-custom px-4 py-2.5 text-decoration-none">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function calculerTotal() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const fees = parseFloat(document.getElementById('fees').value) || 0;
        const type = "{{ $type }}";
        
        let total = 0;
        if (type === 'deposit') {
            total = amount + fees;
        } else {
            total = amount - fees;
        }

        document.getElementById('total').value = total.toLocaleString('fr-FR') + ' FCFA';
        
        // Calcul des commissions
        const askyaPart = fees * 0.60;
        const bankPart = fees * 0.40;
        
        document.getElementById('askya_part').textContent = askyaPart.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('bank_part').textContent = bankPart.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('net_part').textContent = amount.toLocaleString('fr-FR') + ' FCFA';
    }
    
    document.addEventListener('DOMContentLoaded', calculerTotal);
</script>
@endsection
