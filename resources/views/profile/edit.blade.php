@extends('layouts.dashboard')

@section('title', 'Mon Profil')

@section('styles')
<style>
    .profile-container {
        max-width: 900px;
    }
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
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1><i class="fas fa-user-circle me-2 text-primary"></i>Mon Profil</h1>
        <p>Gérez vos informations personnelles et la sécurité de votre compte</p>
    </div>
</div>

<div class="profile-container d-flex flex-column gap-5">
    
    <!-- Profile Information Form -->
    <div class="glass-card">
        <div class="section-header-custom">
            <i class="fas fa-id-card"></i>
            <span>Informations du profil</span>
        </div>
        <p class="text-muted mb-4 fs-6">Mettez à jour les informations de profil et l'adresse e-mail de votre compte.</p>
        
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

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

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label-custom">Nom</label>
                    <input type="text" class="form-control-custom" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label-custom">Adresse email</label>
                    <input type="email" class="form-control-custom" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3">
                <button type="submit" class="btn-custom btn-custom-primary">
                    <i class="fas fa-save me-2"></i>Sauvegarder
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success fw-bold small"><i class="fas fa-check-circle me-1"></i>Enregistré.</span>
                @endif
            </div>
        </form>
    </div>

    <!-- Update Password Form -->
    <div class="glass-card">
        <div class="section-header-custom">
            <i class="fas fa-key"></i>
            <span>Modifier le mot de passe</span>
        </div>
        <p class="text-muted mb-4 fs-6">Assurez-vous que votre compte utilise un mot de passe long et complexe pour rester sécurisé.</p>
        
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="update_password_current_password" class="form-label-custom">Mot de passe actuel</label>
                    <input type="password" class="form-control-custom" id="update_password_current_password" name="current_password" required autocomplete="current-password">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="update_password_password" class="form-label-custom">Nouveau mot de passe</label>
                    <input type="password" class="form-control-custom" id="update_password_password" name="password" required autocomplete="new-password">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="update_password_password_confirmation" class="form-label-custom">Confirmer le mot de passe</label>
                    <input type="password" class="form-control-custom" id="update_password_password_confirmation" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3">
                <button type="submit" class="btn-custom btn-custom-primary">
                    <i class="fas fa-lock me-2"></i>Mettre à jour le mot de passe
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success fw-bold small"><i class="fas fa-check-circle me-1"></i>Mot de passe mis à jour.</span>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete Account Form -->
    <div class="glass-card">
        <div class="section-header-custom">
            <i class="fas fa-user-xmark"></i>
            <span class="text-danger">Supprimer le compte</span>
        </div>
        <p class="text-muted mb-4 fs-6">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement perdues. Veuillez entrer votre mot de passe pour confirmer la suppression.</p>
        
        <button type="button" class="btn-custom btn-custom-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="fas fa-trash me-2"></i>Supprimer le compte
        </button>
    </div>

</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title text-white fw-bold" id="deleteAccountModalLabel">Confirmer la suppression du compte</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body modal-body-custom">
                    <p class="text-muted">Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible et toutes vos données seront définitivement perdues.</p>
                    <div class="mt-4">
                        <label for="password" class="form-label-custom">Saisissez votre mot de passe pour confirmer</label>
                        <input type="password" class="form-control-custom" id="password" name="password" placeholder="Mot de passe" required>
                    </div>
                </div>
                
                <div class="modal-footer modal-footer-custom gap-2">
                    <button type="button" class="btn-custom" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-custom btn-custom-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
