@extends('layouts.app')

@section('title', __('login_title') . ' - ' . __('platform_name'))

@section('content')
<div class="login-page">
    <div class="login-card">
        <!-- En-tête -->
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-home"></i>
            </div>
            <h1 class="login-title">{{ __('login_title') }}</h1>
            <p class="login-subtitle">{{ __('login_subtitle') }}</p>
        </div>

        <!-- Formulaire -->
        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ __('invalid_credentials') }}
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
                           class="form-input @error('email') error @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Entrez votre e-mail" 
                           required 
                           autofocus>
                    @error('email')
                        <div style="color: var(--dark-orange); font-size: 12px; margin-top: 4px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label class="form-label">{{ __('password') }}</label>
                    <div class="password-wrapper">
                        <input type="password"
                               class="form-input @error('password') error @enderror"
                               id="password"
                               name="password"
                               placeholder="{{ __('enter_password') }}"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div style="color: var(--dark-orange); font-size: 12px; margin-top: 4px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox" id="remember" name="remember">
                    <label class="checkbox-label" for="remember">{{ __('remember_me') }}</label>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ __('login_button') }}
                </button>
            </form>

            <!-- Liens -->
            <div class="login-footer">
                <p>{{ __('no_account') }}</p>
                <a href="{{ route('choose.account') }}" class="login-link">
                    {{ __('create_account') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const icon = document.querySelector('.password-toggle i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
@endsection
