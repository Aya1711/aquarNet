@extends('layouts.app')

@section('title', 'Inscription - Nom de la plateforme')

@section('content')
<div class="register-page">
    <div class="register-card">
        <!-- En-tête -->
        <div class="register-header">
            <div class="register-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="register-title">Créer un compte</h1>
            <p class="register-subtitle">Remplissez vos informations pour vous inscrire</p>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Veuillez corriger les erreurs :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm" style="padding: 50px">
            @csrf

            <!-- Nom complet -->
            <div class="form-group">
                <label class="form-label">Nom complet <span class="required">*</span></label>
                <div class="form-input-wrapper">
                    <input type="text" class="form-input" name="name" value="{{ old('name') }}" placeholder="Entrez votre nom complet" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label class="form-label">Téléphone <span class="required">*</span></label>
                <div class="form-input-wrapper">
                    <input type="tel" class="form-input" name="telephone" value="{{ old('telephone') }}" placeholder="Ex : 0612345678" required>
                    <i class="fas fa-phone input-icon"></i>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Adresse e-mail <span class="required">*</span></label>
                <div class="form-input-wrapper">
                    <input type="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="exemple@email.com" required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label class="form-label">Mot de passe <span class="required">*</span></label>
                <div class="form-input-wrapper password-wrapper">
                    <input type="password" class="form-input" id="password" name="password" placeholder="Mot de passe" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <!-- Confirmation mot de passe -->
            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe <span class="required">*</span></label>
                <div class="form-input-wrapper password-wrapper">
                    <input type="password" class="form-input" id="password_confirmation" name="password_confirmation" placeholder="Confirmez le mot de passe" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')"><i class="fas fa-eye"></i></button>
                </div>
                <div id="passwordMatchText" class="help-text"></div>
            </div>

            <!-- Conditions -->
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" class="checkbox" required>
                <label for="terms">
                    J'accepte les <a href="{{ route('terms') }}" target="_blank">conditions d'utilisation</a> et la <a href="{{ route('privacy') }}" target="_blank">politique de confidentialité</a>
                </label>
            </div>

            <!-- Bouton -->
            <button type="submit" class="register-btn"><i class="fas fa-user-plus"></i> Créer mon compte</button>

            <!-- Lien connexion -->
            <div class="register-footer">
                <p>Vous avez déjà un compte ? <a href="{{ route('login') }}" class="login-link">Se connecter</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
:root {
    --orange: #FF6B35;
    --light-orange: #FF8C5A;
    --dark-orange: #E55A2B;
    --white: #FFFFFF;
    --gray: #CED4DA;
}

.register-page {
    min-height: 100vh;
    background: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('/images/bg1.png') no-repeat center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.register-card {
    width: 450px;
    background: rgba(248,249,250,0.18);
    backdrop-filter: blur(15px);
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    padding: 30px;
    color: var(--white);
}

.register-header {
    text-align: center;
    margin-bottom: 25px;
}

.register-logo {
    font-size: 34px;
    color: var(--orange);
    margin-bottom: 10px;
}

.register-title {
    font-size: 28px;
    font-weight: 600;
}

.register-subtitle {
    font-size: 14px;
    color: var(--white);
}

.form-group {
    margin-bottom: 18px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    color: var(--white);
    font-size: 13px;
}

.form-input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 14px 16px 14px 40px;
    border-radius: 12px;
    border: 2px solid black;
    background: transparent;
    color: var(--white);
    outline: none;
    transition: all 0.3s ease;
}

.form-input:focus {
    border-color: var(--orange);
    background: rgba(255,255,255,0.2);
    box-shadow: 0 0 0 3px rgba(255,107,53,0.3);
}

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--white);
}

.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--white);
    cursor: pointer;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: var(--white);
    margin-bottom: 18px;
}

.register-btn {
    width: 100%;
    padding: 14px;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    color: var(--white);
    background: linear-gradient(135deg, var(--light-orange), var(--orange), var(--dark-orange));
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(255,107,53,0.45);
}

.alert {
    padding: 10px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 15px;
}

.alert-error {
    background: rgba(229,90,43,0.25);
    color: #E55A2B;
}

.alert-success {
    background: rgba(255,140,90,0.25);
    color: #FF8C5A;
}

.help-text {
    font-size: 12px;
    margin-top: 4px;
}

.register-footer {
    text-align: center;
    margin-top: 18px;
    font-size: 13px;
    color: var(--white);
}

.login-link {
    color: var(--orange);
    font-weight: 600;
    text-decoration: none;
}

.login-link:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-card {
        width: 92%;
    }
}
</style>
@endsection

@section('scripts')
<script>
function togglePassword(inputId){
    const input = document.getElementById(inputId);
    const icon = input.parentNode.querySelector('.password-toggle i');
    if(input.type === 'password'){
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    }else{
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

document.addEventListener('DOMContentLoaded', function(){
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const matchText = document.getElementById('passwordMatchText');

    function checkMatch(){
        if(confirm.value.length === 0){
            matchText.textContent = '';
            return;
        }
        if(password.value === confirm.value){
            matchText.textContent = 'Les mots de passe correspondent';
            matchText.style.color = '#28a745';
        }else{
            matchText.textContent = 'Les mots de passe ne correspondent pas';
            matchText.style.color = '#dc3545';
        }
    }

    password.addEventListener('input', checkMatch);
    confirm.addEventListener('input', checkMatch);
});
</script>
@endsection
