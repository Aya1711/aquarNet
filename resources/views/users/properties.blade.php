@extends('layouts.app')

@section('title', 'Mes biens')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Mon compte</a></li>
            <li class="breadcrumb-item active">Mes biens</li>
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
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i>Mes biens</h5>
                    <a href="{{ route('properties.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>Ajouter un bien
                    </a>
                </div>
                <div class="card-body">
                    <!-- Statistiques -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white text-center">
                                <div class="card-body py-3">
                                    <h4>{{ $stats['total'] }}</h4>
                                    <p class="mb-0 small">Total des biens</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white text-center">
                                <div class="card-body py-3">
                                    <h4>{{ $stats['active'] }}</h4>
                                    <p class="mb-0 small">Actifs</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white text-center">
                                <div class="card-body py-3">
                                    <h4>{{ $stats['pending'] }}</h4>
                                    <p class="mb-0 small">En attente de validation</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white text-center">
                                <div class="card-body py-3">
                                    <h4>{{ $stats['rejected'] }}</h4>
                                    <p class="mb-0 small">Refusés</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Barre de recherche et filtre -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form action="{{ route('user.properties') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           value="{{ request('search') }}" placeholder="Rechercher dans vos biens...">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" onchange="window.location.href = this.value">
                                <option value="{{ route('user.properties') }}">Tous les statuts</option>
                                <option value="{{ route('user.properties') }}?statut=disponible" 
                                        {{ request('statut') == 'disponible' ? 'selected' : '' }}>Actifs</option>
                                <option value="{{ route('user.properties') }}?statut=en_attente"
                                        {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="{{ route('user.properties') }}?statut=rejete"
                                        {{ request('statut') == 'rejete' ? 'selected' : '' }}>Refusés</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tableau des biens -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Bien</th>
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
                                                 class="rounded me-3" width="60" height="60" style="object-fit: cover;">
                                            @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" 
                                                 width="60" height="60">
                                                <i class="fas fa-home text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ Str::limit($property->titre, 30) }}</h6>
                                                <small class="text-muted">
                                                    {{ $property->created_at->diffForHumans() }}
                                                </small>
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
                                        <span class="badge bg-danger">Refusé</span>
                                        @else
                                        <span class="badge bg-info">{{ $property->statut }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $property->created_at->format('Y/m/d') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('properties.show', $property->id_bien) }}" 
                                               class="btn btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('properties.edit', $property->id_bien) }}" 
                                               class="btn btn-outline-secondary" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('properties.destroy', $property->id_bien) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Aucun bien</h5>
                                        <p class="text-muted">Vous n'avez ajouté aucun bien pour le moment.</p>
                                        <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Ajouter votre premier bien
                                        </a>
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
        </div>
    </div>
</div>
@endsection
