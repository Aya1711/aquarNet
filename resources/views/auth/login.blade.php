@extends('layouts.app')

@section('title', 'Connexion - Plateforme Immobilière')

@section('content')
<div class="login-page">
    <div class="login-card">

        <!-- En-tête -->
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-home"></i>
            </div>
            <h1 class="login-title">Connexion</h1>
            <p class="login-subtitle">Accédez à votre espace personnel</p>
        </div>

        <!-- Corps -->
        <div class="login-body">

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Adresse e-mail ou mot de passe incorrect
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-input @error('email') error @enderror"
                           placeholder="Entrez votre adresse e-mail"
                           required autofocus>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <div class="password-wrapper">
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-input @error('password') error @enderror"
                               placeholder="Entrez votre mot de passe"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox" id="remember" name="remember">
                    <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                </div>

                <!-- Bouton -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Se connecter
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>Vous n’avez pas de compte ?</p>
                <a href="{{ route('choose.account') }}" class="login-link">
                    Créer un compte
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.querySelector('.password-toggle i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
@endsection

<style>
:root {
    --orange: #FF6B35;
    --light-orange: #FF8C5A;
    --dark-orange: #E55A2B;
    --gray: #6C757D;
    --dark-gray: #495057;
    --light-gray: #E9ECEF;
    --beige: #F8F9FA;
    --dark-beige: #E8E8E0;
    --white: #FFFFFF;
}

/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* BACKGROUND */
.login-page {
    min-height: 100vh;
    background:
        linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)),
        url('/images/bg1.png') no-repeat center / cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* CARD */
.login-card {
    width: 500px;
    padding: 30px;
    border-radius: 22px;
    background: rgba(248, 249, 250, 0.18);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    color: var(--white);
}

/* HEADER */
.login-header {
    text-align: center;
    margin-bottom: 25px;
}

.login-logo {
    font-size: 34px;
    color: var(--orange);
    margin-bottom: 10px;
}

.login-title {
    font-size: 30px;
    font-weight: 600;
}

.login-subtitle {
    font-size: 14px;
}

/* FORM */
.form-group {
    margin-bottom: 18px;
}

.form-label {
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
}

.form-input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 12px;
    border: 2px solid black;
    background: transparent;
    color: var(--white);
}

.form-input:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(255,107,53,0.35);
}

.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--white);
    cursor: pointer;
}

/* CHECKBOX */
.checkbox-group {
    display: flex;
    align-items: center;
    margin-bottom: 22px;
}

.checkbox {
    accent-color: var(--orange);
    margin-right: 8px;
}

/* BUTTON */
.login-btn {
    width: 100%;
    padding: 14px;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    color: var(--white);
    background: linear-gradient(135deg, var(--light-orange), var(--orange), var(--dark-orange));
    cursor: pointer;
}

.login-btn:hover {
    transform: translateY(-2px);
}

/* FOOTER */
.login-footer {
    margin-top: 22px;
    text-align: center;
    font-size: 13px;
}

.login-link {
    color: var(--light-orange);
    font-weight: 600;
    text-decoration: none;
}

/* ALERTS */
.alert {
    padding: 10px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 15px;
}

.alert-error {
    background: rgba(229,90,43,0.25);
    color: var(--dark-orange);
}

.alert-success {
    background: rgba(255,140,90,0.25);
    color: var(--light-orange);
}

/* RESPONSIVE */
@media (max-width: 480px) {
    .login-card {
        width: 92%;
    }
}
</style>
