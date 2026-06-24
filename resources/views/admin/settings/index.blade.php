@extends('layouts.dashboard')

@section('title', 'Paramètres')

@section('styles')
<style>
    .section-header-custom {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.15rem;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-glass);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-header-custom i {
        color: #60a5fa;
    }
    .form-check-input {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: var(--border-glass);
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .form-check-label {
        font-weight: 600;
        color: #e2e8f0;
        cursor: pointer;
    }
    .settings-container {
        max-width: 900px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-cog me-2 text-primary"></i>Paramètres</h1>
        <p>Gérez les paramètres généraux et la sécurité de la plateforme</p>
    </div>
</div>

<!-- Settings Card -->
<div class="settings-container">
    <div class="glass-card">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="alert-custom mb-4">
                <i class="fas fa-circle-xmark"></i>
                <div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Informations de l'entreprise -->
            <div class="section-header-custom">
                <i class="fas fa-building"></i>
                <span>Informations de l'entreprise</span>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="entreprise_nom" class="form-label-custom">Nom de l'entreprise</label>
                    <input type="text" class="form-control-custom" id="entreprise_nom" name="entreprise_nom" value="{{ $settings['entreprise_nom'] }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="entreprise_telephone" class="form-label-custom">Téléphone</label>
                    <input type="text" class="form-control-custom" id="entreprise_telephone" name="entreprise_telephone" value="{{ $settings['entreprise_telephone'] }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="entreprise_adresse" class="form-label-custom">Adresse</label>
                    <input type="text" class="form-control-custom" id="entreprise_adresse" name="entreprise_adresse" value="{{ $settings['entreprise_adresse'] }}">
                </div>
                <div class="col-md-12 mb-4">
                    <label for="entreprise_email" class="form-label-custom">Email de contact</label>
                    <input type="email" class="form-control-custom" id="entreprise_email" name="entreprise_email" value="{{ $settings['entreprise_email'] }}">
                </div>
            </div>

            <!-- Sécurité -->
            <div class="section-header-custom">
                <i class="fas fa-shield-alt"></i>
                <span>Sécurité & Accès</span>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="current_password" class="form-label-custom">Mot de passe actuel</label>
                    <input type="password" class="form-control-custom" id="current_password" name="current_password" placeholder="Laisser vide si inchangé">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="new_password" class="form-label-custom">Nouveau mot de passe</label>
                    <input type="password" class="form-control-custom" id="new_password" name="new_password" placeholder="Laisser vide si inchangé">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="new_password_confirmation" class="form-label-custom">Confirmer le nouveau mot de passe</label>
                    <input type="password" class="form-control-custom" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirmez le nouveau mot de passe">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check form-switch mt-md-4">
                        <input class="form-check-input" type="checkbox" id="double_auth" name="double_auth" {{ $settings['double_auth'] ? 'checked' : '' }}>
                        <label class="form-check-label ms-2" for="double_auth">Activer la double authentification</label>
                    </div>
                </div>
            </div>

            <!-- Préférences -->
            <div class="section-header-custom">
                <i class="fas fa-sliders-h"></i>
                <span>Préférences système</span>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label for="langue" class="form-label-custom">Langue par défaut</label>
                    <select class="form-control-custom form-select-custom" id="langue" name="langue" required>
                        <option value="fr" {{ $settings['langue'] == 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="en" {{ $settings['langue'] == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="fuseau_horaire" class="form-label-custom">Fuseau horaire</label>
                    <select class="form-control-custom form-select-custom" id="fuseau_horaire" name="fuseau_horaire" required>
                        <option value="Africa/Abidjan" {{ $settings['fuseau_horaire'] == 'Africa/Abidjan' ? 'selected' : '' }}>Africa/Abidjan</option>
                        <option value="Africa/Dakar" {{ $settings['fuseau_horaire'] == 'Africa/Dakar' ? 'selected' : '' }}>Africa/Dakar</option>
                        <option value="Africa/Lagos" {{ $settings['fuseau_horaire'] == 'Africa/Lagos' ? 'selected' : '' }}>Africa/Lagos</option>
                        <option value="Europe/Paris" {{ $settings['fuseau_horaire'] == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="devise" class="form-label-custom">Devise par défaut</label>
                    <select class="form-control-custom form-select-custom" id="devise" name="devise" required>
                        <option value="XOF" {{ $settings['devise'] == 'XOF' ? 'selected' : '' }}>XOF (FCFA)</option>
                        <option value="EUR" {{ $settings['devise'] == 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                        <option value="USD" {{ $settings['devise'] == 'USD' ? 'selected' : '' }}>USD (Dollar)</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4 pt-2">
                <button type="submit" class="btn-custom btn-custom-primary">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
