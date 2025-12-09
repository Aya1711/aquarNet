@extends('layouts.app')

@section('title', __('register_title') . ' - ' . __('platform_name'))

@section('content')
<div class="register-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Carte principale -->
                <div class="register-card">
                    <!-- En-tête -->
                    <div class="register-header">
                        <div class="register-logo">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h1 class="register-title">{{ __('register_title') }}</h1>
                        <p class="register-subtitle">{{ __('register_subtitle') }}</p>
                    </div>

                    <!-- Corps -->
                    <div class="register-body">
                        @if($errors->any())
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                <strong>{{ __('correct_errors') }}</strong>
                                <ul style="margin: 8px 0 0 16px; padding-right: 16px;">
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

                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- Informations personnelles -->
                            <div class="section-title">
                                <i class="fas fa-user"></i>
                                {{ __('personal_info') }}
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('full_name') }} <span class="required">*</span></label>
                                        <div class="form-input-group">
                                            <span class="input-icon">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text"
                                                   class="form-input"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="{{ __('enter_full_name') }}"
                                                   required
                                                   autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('phone_number') }} <span class="required">*</span></label>
                                        <div class="form-input-group">
                                            <span class="input-icon">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel"
                                                   class="form-input"
                                                   name="telephone"
                                                   value="{{ old('telephone') }}"
                                                   placeholder="Exemple : 0612345678"
                                                   required>
                                        </div>
                                        <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                                            {{ __('phone_help_text') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations du compte -->
                            <div class="section-title">
                                <i class="fas fa-lock"></i>
                                {{ __('account_info') }}
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('email') }} <span class="required">*</span></label>
                                <div class="form-input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-input" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="example@email.com" 
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('password') }} <span class="required">*</span></label>
                                        <div class="form-input-group">
                                            <span class="input-icon">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password"
                                                   class="form-input"
                                                   id="password"
                                                   name="password"
                                                   placeholder="{{ __('enter_password') }}"
                                                   required>
                                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength">
                                            <div class="strength-bar">
                                                <div class="strength-progress" id="strengthProgress"></div>
                                            </div>
                                            <div class="strength-text" id="strengthText"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('confirm_password') }} <span class="required">*</span></label>
                                        <div class="form-input-group">
                                            <span class="input-icon">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password"
                                                   class="form-input"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   placeholder="{{ __('re_enter_password') }}"
                                                   required>
                                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div style="font-size: 12px; margin-top: 4px;" id="passwordMatchText"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Conditions d'utilisation -->
                            <div class="checkbox-group">
                                <input type="checkbox" class="checkbox" id="terms" name="terms" required>
                                <label class="checkbox-label" for="terms">
                                    {{ __('agree_to_terms') }}
                                    <a href="{{ route('terms') }}" target="_blank">{{ __('terms_of_service') }}</a>
                                    {{ __('and') }}
                                    <a href="{{ route('privacy') }}" target="_blank">{{ __('privacy_policy') }}</a>
                                    <span class="required">*</span>
                                </label>
                            </div>

                            <!-- Bouton d'inscription -->
                            <button type="submit" class="register-btn" id="submitBtn">
                                <i class="fas fa-user-plus"></i>
                                {{ __('create_account') }}
                            </button>

                            <!-- Lien de connexion -->
                            <div style="text-align: center; margin-top: 20px;">
                                <p style="color: var(--gray); margin-bottom: 12px; font-size: 14px;">
                                    {{ __('already_have_account') }}
                                </p>
                                <a href="{{ route('login') }}" class="login-link-btn">
                                    <i class="fas fa-sign-in-alt"></i>
                                    {{ __('login') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Carte des agences -->
                <div class="agency-card">
                    <div class="agency-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="agency-title">{{ __('represent_agency') }}</h3>
                    <p class="agency-description">
                        {{ __('join_as_agency') }}
                    </p>
                    <a href="{{ route('register.agency.form') }}" class="agency-btn">
                        <i class="fas fa-plus"></i>
                        {{ __('create_agency_account') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.parentNode.querySelector('.toggle-password i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const matchText = document.getElementById('passwordMatchText');
    const strengthProgress = document.getElementById('strengthProgress');
    const strengthText = document.getElementById('strengthText');
    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;

        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        if (/[^A-Za-z0-9]/.test(password)) strength += 25;

        strengthProgress.style.width = strength + '%';

        if (strength < 50) {
            strengthProgress.style.background = '#dc3545';
            strengthText.textContent = translations.weak;
            strengthText.style.color = '#dc3545';
        } else if (strength < 75) {
            strengthProgress.style.background = '#ffc107';
            strengthText.textContent = translations.medium;
            strengthText.style.color = '#ffc107';
        } else {
            strengthProgress.style.background = '#28a745';
            strengthText.textContent = translations.strong;
            strengthText.style.color = '#28a745';
        }

        checkPasswordMatch();
    });

    confirmInput.addEventListener('input', checkPasswordMatch);

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        if (confirm.length === 0) {
            matchText.textContent = '';
            matchText.style.color = '';
            return;
        }

        if (password === confirm) {
            matchText.textContent = translations.password_match;
            matchText.style.color = '#28a745';
        } else {
            matchText.textContent = translations.password_not_match;
            matchText.style.color = '#dc3545';
        }
    }

    form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        const terms = document.getElementById('terms').checked;

        if (!terms) {
            e.preventDefault();
            alert(translations.accept_terms_required);
            return;
        }

        if (password !== confirm) {
            e.preventDefault();
            alert(translations.password_not_match_alert);
            return;
        }

        if (password.length < 8) {
            e.preventDefault();
            alert(translations.password_min_length);
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + translations.creating_account;
    });
});
</script>
@endsection
