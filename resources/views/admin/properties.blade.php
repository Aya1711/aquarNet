@extends('layouts.app')

@section('title', 'Gestion des biens immobiliers')

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
                    <span>Gestion du contenu</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.properties') }}">
                            <i class="fas fa-home me-2"></i>Biens immobiliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">
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

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des biens immobiliers</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('admin.properties') }}?statut=en_attente" 
                           class="btn btn-sm btn-outline-warning">
                            Biens en attente
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form action="{{ route('admin.properties') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Rechercher des biens...">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <select class="form-select" onchange="window.location.href = this.value">
                        <option value="{{ route('admin.properties') }}">Tous les statuts</option>
                        <option value="{{ route('admin.properties') }}?statut=en_attente" 
                                {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="{{ route('admin.properties') }}?statut=disponible"
                                {{ request('statut') == 'disponible' ? 'selected' : '' }}>Actifs</option>
                        <option value="{{ route('admin.properties') }}?statut=rejete"
                                {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejetés</option>
                    </select>
                </div>
            </div>

            <!-- Properties Table -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Bien</th>
                                    <th>Propriétaire</th>
                                    <th>Type</th>
                                    <th>Ville</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Date d'ajout</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($property->images->count() > 0)
                                            <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                                 class="rounded me-2" width="50" height="50" style="object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ Str::limit($property->titre, 30) }}</h6>
                                                <small class="text-muted">
                                                    @if($property->agence)
                                                    <i class="fas fa-building me-1"></i>{{ $property->agence->nom_agence }}
                                                    @else
                                                    <i class="fas fa-user me-1"></i>Individuel
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $property->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $property->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $property->type }}</span>
                                        <br>
                                        <small class="text-muted">{{ $property->categorie }}</small>
                                    </td>
                                    <td>{{ $property->ville }}</td>
                                    <td>
                                        <strong class="text-primary">
                                            {{ number_format($property->prix, 0, ',', '.') }} MAD
                                        </strong>
                                    </td>
                                    <td>
                                        @if($property->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                        @elseif($property->statut == 'disponible')
                                        <span class="badge bg-success">Actif</span>
                                        @elseif($property->statut == 'rejete')
                                        <span class="badge bg-danger">Rejeté</span>
                                        @else
                                        <span class="badge bg-info">{{ $property->statut }}</span>
                                        @endif
                                        
                                        @if($property->is_featured)
                                        <br>
                                        <span class="badge bg-primary mt-1">Mis en avant</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $property->created_at->format('Y/m/d') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm">
                                            <a href="{{ route('properties.show', $property->id_bien) }}" 
                                               class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                            
                                            @if($property->statut == 'en_attente')
                                            <form action="{{ route('admin.properties.approve', $property->id_bien) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success mb-1 w-100">
                                                    <i class="fas fa-check"></i> Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.properties.reject', $property->id_bien) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger mb-1 w-100">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>
                                            </form>
                                            @endif
                                            
                                            @if($property->statut == 'disponible')
                                                @if($property->is_featured)
                                                <form action="{{ route('admin.properties.unfeature', $property->id_bien) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning mb-1 w-100">
                                                        <i class="fas fa-star"></i> Retirer
                                                    </button>
                                                </form>
                                                @else
                                                <form action="{{ route('admin.properties.feature', $property->id_bien) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-info mb-1 w-100">
                                                        <i class="fas fa-star"></i> Mettre en avant
                                                    </button>
                                                </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Aucun bien disponible</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($properties->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $properties->links() }}
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
