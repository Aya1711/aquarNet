@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container">
    <div class="row">
        <!-- Barre latérale -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">
                        <span class="badge bg-{{ Auth::user()->role == 'agence' ? 'success' : 'primary' }}">
                            {{ Auth::user()->role == 'agence' ? 'Agence immobilière' : 'Particulier' }}
                        </span>
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-envelope me-1"></i>{{ Auth::user()->email }}
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-phone me-1"></i>{{ Auth::user()->telephone }}
                    </p>
                </div>
            </div>

            <!-- Menu latéral -->
            <div class="card shadow-sm mt-3">
                <div class="list-group list-group-flush">
                    <a href="{{ route('user.profile') }}" 
                       class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i>Profil
                    </a>
                    <a href="{{ route('user.properties') }}" 
                       class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i>Mes biens
                    </a>
                    <a href="{{ route('user.favorites') }}" 
                       class="list-group-item list-group-item-action">
                        <i class="fas fa-heart me-2"></i>Favoris
                    </a>
                    <a href="{{ route('users.messages.index') }}" 
                       class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope me-2"></i>Messages
                    </a>
                    <a href="{{ route('user.settings') }}" 
                       class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i>Paramètres
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">
            <!-- Carte principale -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profil</h5>
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nom complet :</th>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <th>Téléphone :</th>
                                    <td>{{ Auth::user()->telephone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Type de compte :</th>
                                    <td>
                                        <span class="badge bg-{{ Auth::user()->role == 'agence' ? 'success' : 'primary' }}">
                                            {{ Auth::user()->role == 'agence' ? 'Agence immobilière' : 'Particulier' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date d'inscription :</th>
                                    <td>{{ Auth::user()->created_at->format('Y/m/d') }}</td>
                                </tr>
                                <tr>
                                    <th>Statut :</th>
                                    <td><span class="badge bg-success">Actif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <h4>{{ $userPropertiesCount }}</h4>
                            <p class="mb-0">Total biens</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white text-center">
                        <div class="card-body">
                            <h4>{{ $activePropertiesCount }}</h4>
                            <p class="mb-0">Biens actifs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <h4>{{ $pendingPropertiesCount }}</h4>
                            <p class="mb-0">En attente de validation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <h4>{{ $favoritesCount }}</h4>
                            <p class="mb-0">Favoris</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers biens -->
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Derniers biens ajoutés</h5>
                    <a href="{{ route('properties.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Ajouter un bien
                    </a>
                </div>
                <div class="card-body">
                    @if($recentProperties->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bien</th>
                                    <th>Type</th>
                                    <th>Ville</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProperties as $property)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($property->images->count() > 0)
                                            <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                                 class="rounded me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <span>{{ Str::limit($property->titre, 30) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $property->type }}</span>
                                    </td>
                                    <td>{{ $property->ville }}</td>
                                    <td>{{ number_format($property->prix, 0, ',', '.') }} MAD</td>
                                    <td>
                                        @if($property->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                        @elseif($property->statut == 'approuve')
                                        <span class="badge bg-success">Approuvé</span>
                                        @else
                                        <span class="badge bg-danger">Refusé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('properties.show', $property->id_bien) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('properties.edit', $property->id_bien) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-home fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Aucun bien ajouté pour le moment</p>
                        <a href="{{ route('properties.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter votre premier bien
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification du profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="telephone" value="{{ Auth::user()->telephone }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" name="current_password">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Profil mis à jour avec succès !');
    $('#editProfileModal').modal('hide');
});
</script>
@endsection
