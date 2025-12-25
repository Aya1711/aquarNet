@extends('layouts.app')

@section('title', "Enregistrement d'une agence immobilière")
@section('body-class', 'register-agency-page')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 bg-gray-50">
    <div class="max-w-6xl w-full">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Côté gauche : optionnel, image ou texte -->
            <div class="hidden lg:flex items-center justify-center bg-blue-100 rounded-3xl p-10">
                <h2 class="text-3xl font-bold text-blue-800 text-center">Bienvenue sur la plateforme immobilière !</h2>
            </div>

            <!-- Côté droit : formulaire -->
            <div class="form-container rounded-3xl shadow-2xl p-8 bg-white" style="padding: 50px">
                <form action="{{ route('register.agency') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informations sur l'agence -->
                    <div>
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-building text-blue-600"></i>
                            Informations sur l'agence
                        </h2>

                        <div class="space-y-4"  style="display:flex; gap: 50px;">
                            <!-- Nom de l'agence -->
                            <div>
                                <i class="fas fa-building text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="nom_agence" class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'agence *</label>
                                <div class="relative">
                                    <input type="text" id="nom_agence" name="nom_agence" value="{{ old('nom_agence') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="Entrez le nom officiel de l'agence">
                                </div>
                                @error('nom_agence')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div>
                                    <i class="fas fa-map-marker-alt text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-2">Adresse complète *</label>
                                <div class="relative">
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="Adresse détaillée de l'agence">
                                </div>
                                @error('adresse')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ville -->
                            <div>
                                    <i class="fas fa-city text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="ville" class="block text-sm font-semibold text-gray-700 mb-2">Ville *</label>
                                <div class="relative">
                                    <input type="text" id="ville" name="ville" value="{{ old('ville') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="Ville où se situe l'agence">
                                </div>
                                @error('ville')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description de l'agence</label>
                                <textarea id="description" name="description" rows="3"
                                          class="input-field w-full px-4 py-3 rounded-xl border resize-none"
                                          placeholder="Brève description de l'agence et de ses activités...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur le responsable -->
                    <div>
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-user-tie text-green-600"></i>
                            Informations sur le responsable
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4"  style="display:flex; gap:30px;">
                            <!-- Nom du responsable -->
                            <div>
                                    <i class="fas fa-user text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom du responsable *</label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="Nom complet du responsable">
                                </div>
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                    <i class="fas fa-phone text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">Numéro de téléphone *</label>
                                <div class="relative">
                                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="05xxxxxxxx">
                                </div>
                                @error('telephone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations de connexion -->
                    <div style="margin-bottom:20px">
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-lock text-purple-600"></i>
                            Informations de connexion
                        </h2>
                        <div class="space-y-4" style="display:flex; gap: 50px;">
                            <!-- Email -->
                            <div>
                                <i class="fas fa-envelope text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse e-mail *</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                           placeholder="email@agence.com">
                                    
                                </div>
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display:flex; gap: 50px;">
                                <!-- Mot de passe -->
                                <div>
                                    <i class="fas fa-key text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe *</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required
                                               class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                               placeholder="Mot de passe">
                                    
                                    </div>
                                    @error('password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmation -->
                                <div>
                                    <i class="fas fa-lock text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmation du mot de passe *</label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                               class="input-field w-full px-4 py-3 pr-12 rounded-xl border"
                                               placeholder="Confirmer le mot de passe">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start space-x-4">
                            <input type="checkbox" id="conditions" name="conditions" required
                                   class="mt-1 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <label for="conditions" class="text-sm text-gray-700 leading-relaxed">
                                J'accepte les 
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">conditions d'utilisation</a> 
                                et la 
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">politique de confidentialité</a>
                                de la plateforme et je garantis l'exactitude des informations fournies.
                            </label>
                        </div>
                        @error('conditions')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton d'inscription -->
                    <button type="submit"
                            class="btn-primary w-full text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-building"></i> Créer un compte agence
                    </button>

                    <!-- Lien connexion -->
                    <div class="text-center pt-6 border-t border-gray-200">
                        <p class="text-gray-600">
                            Vous avez déjà un compte ? 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition duration-200">
                                Se connecter
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-200', 'scale-105');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'scale-105');
        });
    });
});
</script>
@endsection
@section('style')
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
.register-agency-page {
    min-height: 100vh;
    background:
        linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)),
        url('/images/bg1.png') no-repeat center / cover;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

/* CONTAINER */
.register-agency-page .max-w-6xl {
    width: 100%;
}

/* GRID LAYOUT */
.register-agency-page .grid {
    display: grid;
    gap: 30px;
}

/* LEFT SIDE - WELCOME */
.register-agency-page .bg-blue-100 {
    background: rgba(248, 249, 250, 0.15);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    border-radius: 22px;
    padding: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-agency-page .bg-blue-100 h2 {
    color: var(--white);
    font-size: 32px;
    font-weight: 600;
    text-align: center;
}

/* FORM CARD */
.register-agency-page .form-container {
    background: rgba(248, 249, 250, 0.18);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    border-radius: 22px;
    padding: 35px;
}

/* SECTION TITLES */
.register-agency-page .section-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--white);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.register-agency-page .section-title i {
    color: var(--orange);
    font-size: 26px;
}

/* FORM GROUPS */
.register-agency-page .space-y-4 > div,
.register-agency-page .space-y-6 > div {
    margin-bottom: 20px;
}

/* LABELS */
.register-agency-page label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--white);
    margin-bottom: 8px;
}

/* INPUTS */
.register-agency-page .input-field {
    width: 100%;
    padding: 14px 16px 14px 48px;
    border-radius: 12px;
    border: 2px solid rgba(255,255,255,0.3);
    background: transparent;
    color: var(--white);
    font-size: 14px;
    transition: all 0.3s ease;
}

.register-agency-page .input-field::placeholder {
    color: rgba(255,255,255,0.5);
}

.register-agency-page .input-field:focus {
    outline: none;
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(255,107,53,0.35);
}

/* TEXTAREA */
.register-agency-page textarea.input-field {
    padding: 14px 16px;
    min-height: 100px;
    resize: vertical;
}

/* ICONS IN INPUTS */
.register-agency-page .relative {
    position: relative;
}

.register-agency-page .relative i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.6);
    font-size: 16px;
    pointer-events: none;
}

.register-agency-page .input-field:focus + i {
    color: var(--orange);
}

/* GRID FOR INPUTS */
.register-agency-page .grid-cols-1 {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
}

.register-agency-page .md\:grid-cols-2 {
    grid-template-columns: 1fr;
}

@media (min-width: 768px) {
    .register-agency-page .md\:grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* CONDITIONS BOX */
.register-agency-page .bg-blue-50 {
    background: rgba(255, 107, 53, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,107,53,0.3);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.register-agency-page .bg-blue-50 label {
    color: var(--white);
    font-size: 13px;
    line-height: 1.6;
}

/* CHECKBOX */
.register-agency-page input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--orange);
    cursor: pointer;
    flex-shrink: 0;
}

.register-agency-page .bg-blue-50 a {
    color: var(--light-orange);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.register-agency-page .bg-blue-50 a:hover {
    color: var(--orange);
}

/* SUBMIT BUTTON */
.register-agency-page .btn-primary {
    width: 100%;
    padding: 16px;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    font-size: 16px;
    color: var(--white);
    background: linear-gradient(135deg, var(--light-orange), var(--orange), var(--dark-orange));
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.register-agency-page .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255,107,53,0.4);
}

.register-agency-page .btn-primary:active {
    transform: translateY(0);
}

/* FOOTER LINK */
.register-agency-page .text-center {
    text-align: center;
}

.register-agency-page .border-t {
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 20px;
    margin-top: 20px;
}

.register-agency-page .text-gray-600 {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
}

.register-agency-page .text-blue-600 {
    color: var(--light-orange);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.register-agency-page .text-blue-600:hover {
    color: var(--orange);
}

/* ERROR MESSAGES */
.register-agency-page .text-red-600 {
    color: #FFA07A;
    font-size: 12px;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.register-agency-page .text-red-600::before {
    content: "⚠";
    font-size: 14px;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .register-agency-page .lg\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .register-agency-page .hidden.lg\:flex {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .register-agency-page .form-container {
        padding: 25px;
    }
    
    .register-agency-page .section-title {
        font-size: 20px;
    }
    
    .register-agency-page .section-title i {
        font-size: 22px;
    }
}

@media (max-width: 480px) {
    .register-agency-page {
        padding: 20px 10px;
    }
    
    .register-agency-page .form-container {
        padding: 20px;
    }
    
    .register-agency-page .section-title {
        font-size: 18px;
    }
}

/* ANIMATIONS */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.register-agency-page .form-container {
    animation: fadeInUp 0.6s ease-out;
}

/* ACCESSIBILITY */
.register--page *:focus-visible {
    outline:agency 3px solid var(--orange);
    outline-offset: 2px;
}
</style>
@endsection






