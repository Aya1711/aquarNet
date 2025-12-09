@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu Principal</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Gestion de contenu</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.properties') }}">
                            <i class="fas fa-home me-2"></i>Biens immobiliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.users') }}">
                            <i class="fas fa-users me-2"></i>Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.agencies') }}">
                            <i class="fas fa-building me-2"></i>Agences
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des utilisateurs</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('admin.users') }}?role=particulier" 
                           class="btn btn-sm btn-outline-primary">Particuliers</a>
                        <a href="{{ route('admin.users') }}?role=agence" 
                           class="btn btn-sm btn-outline-success">Agences</a>
                        <a href="{{ route('admin.users') }}?role=admin" 
                           class="btn btn-sm btn-outline-danger">Administrateurs</a>
                    </div>
                </div>
            </div>

            <!-- Search bar -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form action="{{ route('admin.users') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Rechercher des utilisateurs...">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <select class="form-select" onchange="window.location.href = this.value">
                        <option value="{{ route('admin.users') }}">Tous les rôles</option>
                        <option value="{{ route('admin.users') }}?role=admin" 
                                {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                        <option value="{{ route('admin.users') }}?role=agence"
                                {{ request('role') == 'agence' ? 'selected' : '' }}>Agences</option>
                        <option value="{{ route('admin.users') }}?role=particulier"
                                {{ request('role') == 'particulier' ? 'selected' : '' }}>Particuliers</option>
                    </select>
                </div>
            </div>

            <!-- Users table -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Rôle</th>
                                    <th>Nombre de biens</th>
                                    <th>Date d'inscription</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $user->name }}</h6>
                                                @if($user->agence)
                                                <small class="text-muted">{{ $user->agence->nom_agence }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telephone ?? 'Non défini' }}</td>

                                    <td>
                                        @if($user->role == 'admin')
                                        <span class="badge bg-danger">Administrateur</span>
                                        @elseif($user->role == 'agence')
                                        <span class="badge bg-success">Agence</span>
                                        @else
                                        <span class="badge bg-primary">Particulier</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-info">{{ $user->biens_count }}</span>
                                    </td>

                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('Y/m/d') }}</small>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>

                                    <td>
                                        <div class="btn-group-vertical btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary mb-1" 
                                                    data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id_user }}">
                                                <i class="fas fa-eye"></i> Détails
                                            </button>

                                            @if($user->id_user != Auth::id())
                                            <button type="button" class="btn btn-outline-warning mb-1" 
                                                    data-bs-toggle="modal" data-bs-target="#roleModal{{ $user->id_user }}">
                                                <i class="fas fa-user-cog"></i> Rôles
                                            </button>
                                            @endif
                                        </div>

                                        <!-- User details modal -->
                                        <div class="modal fade" id="userModal{{ $user->id_user }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Détails de l'utilisateur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Personal info -->
                                                            <div class="col-md-6">
                                                                <h6>Informations personnelles</h6>
                                                                <table class="table table-bordered">
                                                                    <tr><th>Nom :</th><td>{{ $user->name }}</td></tr>
                                                                    <tr><th>Email :</th><td>{{ $user->email }}</td></tr>
                                                                    <tr><th>Téléphone :</th><td>{{ $user->telephone ?? 'Non défini' }}</td></tr>
                                                                    <tr>
                                                                        <th>Rôle :</th>
                                                                        <td>
                                                                            @if($user->role == 'admin')
                                                                            <span class="badge bg-danger">Administrateur</span>
                                                                            @elseif($user->role == 'agence')
                                                                            <span class="badge bg-success">Agence</span>
                                                                            @else
                                                                            <span class="badge bg-primary">Particulier</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <!-- Stats -->
                                                            <div class="col-md-6">
                                                                <h6>Statistiques</h6>
                                                                <table class="table table-bordered">
                                                                    <tr><th>Biens :</th><td>{{ $user->biens_count }}</td></tr>
                                                                    <tr><th>Date d'inscription :</th><td>{{ $user->created_at->format('Y/m/d') }}</td></tr>
                                                                    <tr><th>Dernière activité :</th><td>{{ $user->updated_at->diffForHumans() }}</td></tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        @if($user->agence)
                                                        <div class="mt-3">
                                                            <h6>Informations de l'agence</h6>
                                                            <table class="table table-bordered">
                                                                <tr><th>Nom de l'agence :</th><td>{{ $user->agence->nom_agence }}</td></tr>
                                                                <tr><th>Adresse :</th><td>{{ $user->agence->adresse }}</td></tr>
                                                                <tr><th>Ville :</th><td>{{ $user->agence->ville }}</td></tr>
                                                            </table>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Roles modal -->
                                        @if($user->id_user != Auth::id())
                                        <div class="modal fade" id="roleModal{{ $user->id_user }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier le rôle</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form action="{{ route('admin.users.role', $user->id_user) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Sélectionner un rôle</label>
                                                                <select class="form-select" name="role" required>
                                                                    <option value="particulier" {{ $user->role == 'particulier' ? 'selected' : '' }}>Particulier</option>
                                                                    <option value="agence" {{ $user->role == 'agence' ? 'selected' : '' }}>Agence</option>
                                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                                </select>
                                                            </div>

                                                            <div class="alert alert-warning">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                Attention lors de la modification des rôles.
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-warning">Modifier</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                    @endif

                </div>
            </div>

        </main>
    </div>
</div>
@endsection

@section('styles')
<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset 1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
    padding: 0.75rem 1rem;
}

.sidebar .nav-link.active {
    color: #007bff;
    background-color: #e7f1ff;
}

.sidebar .nav-link:hover {
    color: #007bff;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
}

.btn-group-vertical .btn {
    text-align: right;
}
</style>
@endsection
