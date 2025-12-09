@extends('layouts.app')

@section('title', 'Modifier le profil')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Mon compte</a></li>
            <li class="breadcrumb-item active">Modifier le profil</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Barre latérale -->
        <div class="col-md-3">
            @include('users.partials.sidebar')
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Modifier le profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Informations de base -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">Informations de base</h6>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" name="telephone" value="{{ old('telephone', Auth::user()->telephone) }}" required>
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Changer le mot de passe -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">Changer le mot de passe</h6>
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Laissez vide si vous ne voulez pas changer le mot de passe</div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" class="form-control" 
                                           id="new_password_confirmation" name="new_password_confirmation">
                                </div>

                                <!-- Indicateur de force du mot de passe -->
                                <div class="password-strength mb-3" style="display: none;">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="password-strength-text text-muted"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Si l'utilisateur est une agence -->
                        @if(Auth::user()->isAgence() && Auth::user()->agence)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3">Informations de l'agence</h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'agence</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->agence->nom_agence }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ville</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->agence->ville }}" readonly>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Adresse de l'agence</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->agence->adresse }}" readonly>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Pour modifier les informations de l'agence, veuillez <a href="{{ route('agencies.dashboard') }}" class="alert-link">visiter le tableau de bord de l'agence</a>.
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Boutons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.profile') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>Annuler
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section suppression -->
            @if(!Auth::user()->isAdmin())
            <div class="card shadow mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Zone de danger</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6 class="alert-heading"><i class="fas fa-warning me-2"></i>Attention !</h6>
                        <p class="mb-2">La suppression du compte est irréversible. Toutes vos données seront supprimées, y compris vos biens, messages et favoris.</p>
                    </div>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i>Supprimer le compte
                    </button>
                </div>
            </div>

            <!-- Modal suppression compte -->
            <div class="modal fade" id="deleteAccountModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirmer la suppression du compte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Cette action est irréversible !</strong>
                            </div>
                            <p>Les éléments suivants seront supprimés :</p>
                            <ul>
                                <li>Tous vos biens</li>
                                <li>Vos messages</li>
                                <li>Vos favoris</li>
                                <li>Toutes vos informations personnelles</li>
                            </ul>
                            <p>Vous ne pourrez pas récupérer ces données.</p>
                            
                            <div class="mb-3">
                                <label for="confirmDelete" class="form-label">
                                    Tapez "<strong>Supprimer mon compte</strong>" pour confirmer :
                                </label>
                                <input type="text" class="form-control" id="confirmDelete">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                                <i class="fas fa-trash me-2"></i>Supprimer le compte
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérification de la force du mot de passe
    const newPassword = document.getElementById('new_password');
    const strengthBar = document.querySelector('.password-strength .progress-bar');
    const strengthText = document.querySelector('.password-strength-text');
    const strengthContainer = document.querySelector('.password-strength');

    newPassword.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length > 0) {
            strengthContainer.style.display = 'block';
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Faible';
            } else if (strength < 75) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Moyenne';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Forte';
            }
        } else {
            strengthContainer.style.display = 'none';
        }
    });

    // Vérification de la correspondance du mot de passe
    const confirmPassword = document.getElementById('new_password_confirmation');
    confirmPassword.addEventListener('input', function() {
        if (this.value !== newPassword.value) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Vérification de la suppression du compte
    const confirmDelete = document.getElementById('confirmDelete');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    confirmDelete.addEventListener('input', function() {
        if (this.value === 'Supprimer mon compte') {
            confirmDeleteBtn.disabled = false;
        } else {
            confirmDeleteBtn.disabled = true;
        }
    });

    // Confirmer la suppression du compte
    confirmDeleteBtn.addEventListener('click', function() {
        // Ici, vous pouvez ajouter une requête AJAX pour supprimer le compte
        alert('La suppression du compte sera effectuée. Ceci est un aperçu.');
        $('#deleteAccountModal').modal('hide');
    });

    // Vérification du formulaire avant soumission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        if (newPassword && newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Le nouveau mot de passe et sa confirmation ne correspondent pas.');
        }
    });
});
</script>
@endsection
