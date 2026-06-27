@extends('layouts.dashboard')

@section('title', 'Modifier la Caisse')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.registers.index') }}" class="text-primary text-decoration-none">Caisses</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Modifier caisse</li>
        </ol>
    </nav>
    <div class="page-title d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Modifier la Caisse {{ $register->name }}</h1>
            <p>Code: <strong>{{ $register->code }}</strong></p>
        </div>
        <a href="{{ route('admin.registers.index') }}" class="btn-custom">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    <form action="{{ route('admin.registers.update', $register) }}" method="POST" id="registerForm" class="d-flex flex-column gap-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label-custom">Nom de la caisse *</label>
                <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" 
                       id="name" name="name" required value="{{ old('name') ?? $register->name }}">
                @error('name')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="code" class="form-label-custom">Code Caisse (unique) *</label>
                <input type="text" class="form-control form-control-custom @error('code') is-invalid @enderror" 
                       id="code" name="code" required value="{{ old('code') ?? $register->code }}">
                @error('code')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="type" class="form-label-custom">Type de Caisse *</label>
                <select class="form-control form-control-custom form-select-custom @error('type') is-invalid @enderror" 
                        id="type" name="type" required onchange="toggleFields()">
                    <option value="cashier" {{ (old('type') ?? $register->type) == 'cashier' ? 'selected' : '' }}>Caisse Caissier</option>
                    <option value="main" {{ (old('type') ?? $register->type) == 'main' ? 'selected' : '' }}>Caisse Principale d'Agence</option>
                    <option value="bank" {{ (old('type') ?? $register->type) == 'bank' ? 'selected' : '' }}>Compte Bancaire</option>
                </select>
                @error('type')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="agency_id" class="form-label-custom">Agence d'affectation *</label>
                <select class="form-control form-control-custom form-select-custom @error('agency_id') is-invalid @enderror" 
                        id="agency_id" name="agency_id" required>
                    <option value="">Sélectionnez l'agence</option>
                    @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ (old('agency_id') ?? $register->agency_id) == $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                    @endforeach
                </select>
                @error('agency_id')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Field for Bank -->
        <div class="row g-3" id="bankField" style="display: none;">
            <div class="col-md-12">
                <label for="bank_id" class="form-label-custom">Banque Partenaire *</label>
                <select class="form-control form-control-custom form-select-custom @error('bank_id') is-invalid @enderror" 
                        id="bank_id" name="bank_id">
                    <option value="">Sélectionnez la banque</option>
                    @foreach($banks as $bank)
                    <option value="{{ $bank->id }}" {{ (old('bank_id') ?? $register->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                    @endforeach
                </select>
                @error('bank_id')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Field for User assignment -->
        <div class="row g-3" id="userField">
            <div class="col-md-12">
                <label for="assigned_to" class="form-label-custom">Caissier Assigné *</label>
                <select class="form-control form-control-custom form-select-custom @error('assigned_to') is-invalid @enderror" 
                        id="assigned_to" name="assigned_to">
                    <option value="">Sélectionnez le caissier</option>
                    @foreach($users->where('role.value', 'caissier') as $user)
                    <option value="{{ $user->id }}" {{ (old('assigned_to') ?? $register->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="balance" class="form-label-custom">Solde actuel (FCFA) *</label>
                <input type="number" class="form-control form-control-custom @error('balance') is-invalid @enderror" 
                       id="balance" name="balance" required value="{{ old('balance') ?? $register->balance }}">
                @error('balance')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label for="is_active" class="form-label-custom">Statut *</label>
                <select class="form-control form-control-custom form-select-custom @error('is_active') is-invalid @enderror" 
                        id="is_active" name="is_active" required>
                    <option value="1" {{ (old('is_active') ?? $register->is_active) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !(old('is_active') ?? $register->is_active) ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <button type="submit" class="btn-custom btn-custom-primary px-4 py-2.5">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <a href="{{ route('admin.registers.index') }}" class="btn-custom px-4 py-2.5 text-decoration-none">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        const bankField = document.getElementById('bankField');
        const userField = document.getElementById('userField');
        
        if (type === 'bank') {
            bankField.style.display = 'block';
            document.getElementById('bank_id').required = true;
            userField.style.display = 'none';
            document.getElementById('assigned_to').required = false;
        } else if (type === 'cashier') {
            bankField.style.display = 'none';
            document.getElementById('bank_id').required = false;
            userField.style.display = 'block';
            document.getElementById('assigned_to').required = true;
        } else {
            bankField.style.display = 'none';
            document.getElementById('bank_id').required = false;
            userField.style.display = 'none';
            document.getElementById('assigned_to').required = false;
        }
    }
    
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection
