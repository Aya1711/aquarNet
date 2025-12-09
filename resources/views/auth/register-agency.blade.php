@extends('layouts.app')

@section('title', 'Enregistrement d\'une agence immobilière')

@section('body-class', 'register-agency-page')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4">
    <div class="max-w-6xl w-full">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Côté gauche - fonctionnalités (vous pouvez ajouter ici) -->

            <!-- Côté droit - formulaire d'inscription -->
            <div class="form-container rounded-3xl shadow-2xl p-8">
                <form action="{{ route('register.agency') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Informations sur l'agence -->
                    <div>
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-building text-blue-600 ml-3"></i>
                            Informations sur l'agence
                        </h2>

                        <div class="space-y-4">
                            <!-- Nom de l'agence -->
                            <div>
                                <label for="nom_agence" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nom de l'agence *
                                </label>
                                <div class="relative">
                                    <input type="text" id="nom_agence" name="nom_agence" value="{{ old('nom_agence') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="Entrez le nom officiel de l'agence">
                                    <i class="fas fa-building text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div>
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Adresse complète *
                                </label>
                                <div class="relative">
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="Adresse détaillée de l'agence">
                                    <i class="fas fa-map-marker-alt text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Ville -->
                            <div>
                                <label for="ville" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ville *
                                </label>
                                <div class="relative">
                                    <input type="text" id="ville" name="ville" value="{{ old('ville') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="Ville où se situe l'agence">
                                    <i class="fas fa-city text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Description de l'agence
                                </label>
                                <textarea id="description" name="description" rows="3"
                                          class="input-field w-full px-4 py-3 rounded-xl resize-none"
                                          placeholder="Brève description de l'agence et de ses activités...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur le responsable -->
                    <div>
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-user-tie text-green-600 ml-3"></i>
                            Informations sur le responsable
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nom du responsable -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nom du responsable *
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="Nom complet du responsable">
                                    <i class="fas fa-user text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Numéro de téléphone *
                                </label>
                                <div class="relative">
                                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="05xxxxxxxx">
                                    <i class="fas fa-phone text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de connexion -->
                    <div>
                        <h2 class="section-title text-2xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-lock text-purple-600 ml-3"></i>
                            Informations de connexion
                        </h2>

                        <div class="space-y-4">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Adresse e-mail *
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                           placeholder="email@agence.com">
                                    <i class="fas fa-envelope text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Mot de passe -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Mot de passe *
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required
                                               class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                               placeholder="Mot de passe">
                                        <i class="fas fa-key text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                    </div>
                                </div>

                                <!-- Confirmation du mot de passe -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmation du mot de passe *
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                               class="input-field w-full px-4 py-3 pr-12 rounded-xl"
                                               placeholder="Confirmer le mot de passe">
                                        <i class="fas fa-lock text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions d'utilisation -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start space-x-4 space-x-reverse">
                            <input type="checkbox" id="conditions" name="conditions" required
                                   class="mt-1 text-blue-600 focus:ring-blue-500 rounded border-gray-300">
                            <label for="conditions" class="text-sm text-gray-700 leading-relaxed">
                                J'accepte les 
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">conditions d'utilisation</a> 
                                et la 
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">politique de confidentialité</a>
                                de la plateforme immobilière et je garantis l'exactitude des informations fournies.
                            </label>
                        </div>
                    </div>

                    <!-- Bouton d'inscription -->
                    <button type="submit"
                            class="btn-primary w-full text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg">
                        <i class="fas fa-building ml-3"></i>
                        Créer un compte agence
                    </button>

                    <!-- Lien de connexion -->
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
