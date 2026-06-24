@extends('layouts.dashboard')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none">Utilisateurs</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Créer</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1><i class="fas fa-user-plus me-2 text-primary"></i>Créer un utilisateur</h1>
        <p>Ajoutez un nouvel utilisateur et attribuez-lui des rôles et des autorisations d'agence.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 800px;">
    @if ($errors->any())
    <div class="alert-custom mb-4">
        <i class="fas fa-circle-xmark"></i>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-md-6">
                <label for="first_name" class="form-label-custom">Prénom *</label>
                <input type="text" class="form-control-custom" id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="Ex: Jean">
            </div>
            
            <div class="col-md-6">
                <label for="last_name" class="form-label-custom">Nom *</label>
                <input type="text" class="form-control-custom" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Ex: Dupont">
            </div>
        </div>

        <div class="mt-4">
            <label for="email" class="form-label-custom">Adresse e-mail *</label>
            <input type="email" class="form-control-custom" id="email" name="email" value="{{ old('email') }}" required placeholder="exemple@askya-finance.com">
        </div>

        <div class="mt-4">
            <label for="role" class="form-label-custom">Rôle *</label>
            <select class="form-control-custom form-select-custom" id="role" name="role" required onchange="toggleAgencyField()">
                <option value="">Sélectionner un rôle</option>
                @foreach($roles as $role)
                <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                    {{ ucfirst($role->value) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4" id="agency-field" style="display: none;">
            <label for="agency_id" class="form-label-custom">Agence *</label>
            <select class="form-control-custom form-select-custom" id="agency_id" name="agency_id">
                <option value="">Sélectionner une agence</option>
                @foreach($agencies as $agency)
                <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                    {{ $agency->name }} ({{ $agency->code }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-6">
                <label for="password" class="form-label-custom">Mot de passe *</label>
                <input type="password" class="form-control-custom" id="password" name="password" required placeholder="Mot de passe">
            </div>
            
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label-custom">Confirmer le mot de passe *</label>
                <input type="password" class="form-control-custom" id="password_confirmation" name="password_confirmation" required placeholder="Confirmer le mot de passe">
            </div>
        </div>

        <div class="d-flex gap-3 mt-5">
            <button type="submit" class="btn-custom btn-custom-primary">
                <i class="fas fa-save"></i> Créer l'utilisateur
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-custom">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleAgencyField() {
        const roleSelect = document.getElementById('role');
        const agencyField = document.getElementById('agency-field');
        const agencySelect = document.getElementById('agency_id');

        if (roleSelect.value === 'caissier') {
            agencyField.style.display = 'block';
            agencySelect.required = true;
        } else {
            agencyField.style.display = 'none';
            agencySelect.required = false;
            agencySelect.value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleAgencyField();
    });
</script>
@endsection

