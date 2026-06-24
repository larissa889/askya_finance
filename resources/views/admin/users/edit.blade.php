@extends('layouts.dashboard')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background: transparent; padding: 0;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none">Utilisateurs</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Modifier</li>
        </ol>
    </nav>
    <div class="page-title">
        <h1><i class="fas fa-edit me-2 text-primary"></i>Modifier l'utilisateur</h1>
        <p>Modifiez les informations personnelles, les rôles et l'affectation d'agence pour {{ $user->name }}.</p>
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

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="first_name" class="form-label-custom">Prénom *</label>
                <input type="text" class="form-control-custom" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required placeholder="Prénom">
            </div>
            
            <div class="col-md-6">
                <label for="last_name" class="form-label-custom">Nom *</label>
                <input type="text" class="form-control-custom" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required placeholder="Nom">
            </div>
        </div>

        <div class="mt-4">
            <label for="email" class="form-label-custom">Adresse e-mail *</label>
            <input type="email" class="form-control-custom" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="exemple@askya-finance.com">
        </div>

        <div class="mt-4">
            <label for="role" class="form-label-custom">Rôle *</label>
            <select class="form-control-custom form-select-custom" id="role" name="role" required onchange="toggleAgencyField()">
                <option value="">Sélectionner un rôle</option>
                @foreach($roles as $role)
                <option value="{{ $role->value }}" {{ old('role', $user->role->value) == $role->value ? 'selected' : '' }}>
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
                <option value="{{ $agency->id }}" {{ old('agency_id', $user->agency_id) == $agency->id ? 'selected' : '' }}>
                    {{ $agency->name }} ({{ $agency->code }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-6">
                <label for="password" class="form-label-custom">Mot de passe <small class="text-muted">(laisser vide pour ne pas changer)</small></label>
                <input type="password" class="form-control-custom" id="password" name="password" placeholder="Nouveau mot de passe">
            </div>
            
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label-custom">Confirmer le mot de passe</label>
                <input type="password" class="form-control-custom" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe">
            </div>
        </div>

        <div class="d-flex gap-3 mt-5">
            <button type="submit" class="btn-custom btn-custom-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
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

