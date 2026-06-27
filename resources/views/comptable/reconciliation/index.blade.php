@extends('layouts.dashboard')

@section('title', 'Rapprochement Bancaire')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Rapprochement Bancaire</h1>
        <p>Comparez les relevés bancaires avec les transactions enregistrées dans le système.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="glass-card">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-file-csv text-primary me-2"></i>Importer un Relevé Bancaire</h4>
            <form action="{{ route('comptable.reconciliation.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                @csrf
                
                <div>
                    <label for="bank_id" class="form-label-custom">Banque Partenaire *</label>
                    <select class="form-control form-control-custom form-select-custom @error('bank_id') is-invalid @enderror" id="bank_id" name="bank_id" required>
                        <option value="">Sélectionnez la banque...</option>
                        @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }} ({{ $bank->code }})</option>
                        @endforeach
                    </select>
                    @error('bank_id')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="statement_file" class="form-label-custom">Fichier de Relevé (CSV) *</label>
                    <input type="file" class="form-control form-control-custom @error('statement_file') is-invalid @enderror" id="statement_file" name="statement_file" accept=".csv" required>
                    @error('statement_file')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    <div class="text-muted small mt-2">Le fichier CSV doit contenir les colonnes dans l'ordre suivant : **Date, Référence, Description, Montant, Type (credit/debit)**.</div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                        <i class="fas fa-sync me-2"></i> Lancer le Rapprochement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="glass-card h-100">
            <h4 class="mb-4 fw-bold text-white"><i class="fas fa-circle-question text-primary me-2"></i>Aide & Format</h4>
            <p class="text-muted">Pour effectuer un rapprochement, exportez le relevé de votre banque (Orabank, UBA, BSIC) au format CSV.</p>
            <p class="text-muted">Exemple de lignes CSV attendues :</p>
            <div class="p-3 rounded-4 font-monospace small" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); color: #94a3b8;">
                date,reference,description,amount,type<br>
                2026-06-25,TXN-20260625-0001,Dépôt client Orange Money,15000,credit<br>
                2026-06-25,TXN-20260625-0002,Retrait Wave,50000,debit
            </div>
        </div>
    </div>
</div>
@endsection
