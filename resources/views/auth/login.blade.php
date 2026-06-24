<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Askya Finance</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #030712;
            --bg-darker: #02040a;
            --card-glass: rgba(17, 24, 39, 0.6);
            --border-glass: rgba(255, 255, 255, 0.08);
            --primary-accent: #3b82f6;
            --secondary-accent: #6366f1;
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--bg-dark);
            color: var(--text-light);
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Arrière-plan technologique et lumineux */
        .bg-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.01) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: center;
            z-index: -2;
            pointer-events: none;
        }

        .bg-mesh-1 {
            position: fixed;
            top: -15%;
            left: -15%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            pointer-events: none;
            animation: drift 20s infinite alternate ease-in-out;
        }

        .bg-mesh-2 {
            position: fixed;
            bottom: -15%;
            right: -15%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, rgba(236, 72, 153, 0) 70%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            pointer-events: none;
            animation: drift 25s infinite alternate-reverse ease-in-out;
        }

        @keyframes drift {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(60px, 40px) scale(1.1); }
            100% { transform: translate(-40px, -60px) scale(0.9); }
        }

        /* Card de Connexion Centralisée */
        .login-card {
            background: var(--card-glass);
            border: 1px solid var(--border-glass);
            border-radius: 28px;
            padding: 50px 45px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.55), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
            width: 100%;
            max-width: 480px;
            backdrop-filter: blur(30px);
            z-index: 2;
            animation: cardSlideIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            margin: 20px;
        }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo & En-tête */
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 35px;
            text-align: center;
        }

        .logo-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 16px;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
            position: relative;
        }

        .logo-icon-box i {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 8px rgba(59, 130, 246, 0.4));
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Formulaire */
        .form-label {
            font-weight: 700;
            color: #e2e8f0;
            font-size: 0.85rem;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom i.input-icon {
            position: absolute;
            left: 18px;
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 3;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--border-glass) !important;
            border-radius: 14px !important;
            padding: 14px 16px 14px 48px !important;
            font-size: 0.95rem;
            color: var(--text-light) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-custom::placeholder {
            color: rgba(148, 163, 184, 0.4);
        }

        .form-control-custom:focus {
            outline: none !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            background: rgba(255, 255, 255, 0.04) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        .form-control-custom:focus + i.input-icon {
            color: var(--primary-accent);
        }

        .password-toggle-btn {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            transition: color 0.3s ease;
            z-index: 3;
        }

        .password-toggle-btn:hover {
            color: var(--text-light);
        }

        /* Checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
        }

        .form-check-input-custom {
            width: 18px;
            height: 18px;
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-glass);
            border-radius: 6px;
            cursor: pointer;
            appearance: none;
            position: relative;
            transition: all 0.2s ease;
        }

        .form-check-input-custom:checked {
            background-color: var(--primary-accent);
            border-color: var(--primary-accent);
        }

        .form-check-input-custom:checked::after {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 0.75rem;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-check-label-custom {
            color: var(--text-muted);
            font-size: 0.9rem;
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        /* Bouton Premium */
        .btn-premium {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 15px 24px;
            font-size: 1.05rem;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.25);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: 0.5s;
        }

        .btn-premium:hover::before {
            left: 100%;
        }

        .btn-premium:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 25px rgba(59, 130, 246, 0.4);
            filter: brightness(1.1);
        }

        .btn-premium:active {
            transform: translateY(0);
        }

        .forgot-password-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .forgot-password-link:hover {
            color: var(--primary-accent);
        }

        /* Alertes */
        .alert-custom {
            border-radius: 14px;
            border: 1px solid rgba(239, 68, 68, 0.15);
            background-color: rgba(239, 68, 68, 0.04);
            color: #f87171;
            padding: 14px 18px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-custom-success {
            border: 1px solid rgba(16, 185, 129, 0.15);
            background-color: rgba(16, 185, 129, 0.04);
            color: #34d399;
        }

        /* Footer */
        .footer-login {
            position: absolute;
            bottom: 25px;
            left: 0;
            right: 0;
            text-align: center;
            color: rgba(148, 163, 184, 0.3);
            font-size: 0.8rem;
            z-index: 10;
            pointer-events: none;
            padding: 0 20px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 35px 25px;
                box-shadow: none;
                border: none;
                background: transparent;
                backdrop-filter: none;
            }
            
            .logo-text {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-mesh-1"></div>
    <div class="bg-mesh-2"></div>

    <div class="login-card">
        <!-- Logo & Brand Header -->
        <div class="logo-container">
            <div class="logo-icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <span class="logo-text">Askya Finance</span>
            <span class="subtitle">Connectez-vous pour accéder à votre espace</span>
        </div>

        <!-- Status Session Alerts -->
        @if (session('status'))
            <div class="alert-custom alert-custom-success">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label">Identifiant ou Adresse e-mail</label>
                <div class="input-group-custom">
                    <input type="email" 
                           class="form-control-custom @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="nom@askya.com">
                    <i class="fa-regular fa-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="text-danger mt-2" style="font-size: 0.85rem; font-weight: 500;">
                        <i class="fas fa-circle-exclamation me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Mot de passe</label>
                </div>
                <div class="input-group-custom">
                    <input type="password" 
                           class="form-control-custom @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="••••••••">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                        <i class="fa-regular fa-eye" id="password-icon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger mt-2" style="font-size: 0.85rem; font-weight: 500;">
                        <i class="fas fa-circle-exclamation me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input class="form-check-input-custom" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label-custom" for="remember_me">
                    Se souvenir de moi
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-premium">
                <span>Se connecter</span>
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-password-link">
                Mot de passe oublié ?
            </a>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer-login">
        © 2026 Askya Finance. Tous droits réservés. Sécurisé par chiffrement SSL.
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
