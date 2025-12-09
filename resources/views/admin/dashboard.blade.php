@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Gestion du Contenu</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.properties') }}">
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

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Statistiques</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar me-2"></i>Rapports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog me-2"></i>Paramètres
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de bord Administrateur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exporter</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Imprimer</button>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total des biens</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_properties'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Biens en attente de validation</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_properties'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total des utilisateurs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Agences immobilières</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['agencies_count'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers biens -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Derniers biens ajoutés</h6>
                            <a href="{{ route('admin.properties') }}" class="btn btn-sm btn-primary">Voir tout</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
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
                                        @forelse($recentProperties as $property)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($property->images->count() > 0)
                                                    <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                                         class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="font-weight-bold">{{ Str::limit($property->titre, 30) }}</div>
                                                        <small class="text-muted">
                                                            {{ $property->user->name }}
                                                            @if($property->agence)
                                                            - {{ $property->agence->nom_agence }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $property->type }}</span><br>
                                                <small class="text-muted">{{ $property->categorie }}</small>
                                            </td>
                                            <td>{{ $property->ville }}</td>
                                            <td>{{ number_format($property->prix, 0, ',', '.') }} MAD</td>
                                            <td>
                                                @if($property->statut == 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                                @elseif($property->statut == 'approuve')
                                                <span class="badge bg-success">Approuvé</span>
                                                @elseif($property->statut == 'rejete')
                                                <span class="badge bg-danger">Rejeté</span>
                                                @else
                                                <span class="badge bg-info">{{ $property->statut }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('properties.show', $property->id_bien) }}" 
                                                       class="btn btn-outline-primary" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($property->statut == 'en_attente')
                                                    <form action="{{ route('admin.properties.approve', $property->id_bien) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" title="Approuver">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.properties.reject', $property->id_bien) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" title="Rejeter">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="fas fa-home fa-2x text-muted mb-3"></i>
                                                <p class="text-muted">Aucun bien trouvé</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biens en attente -->
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">Biens en attente de validation</h6>
                        </div>
                        <div class="card-body">
                            @forelse($pendingProperties as $property)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                @if($property->images->count() > 0)
                                <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                     class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" 
                                     width="50" height="50">
                                    <i class="fas fa-home text-muted"></i>
                                </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ Str::limit($property->titre, 25) }}</h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-user me-1"></i>{{ $property->user->name }}
                                    </p>
                                    <p class="text-primary mb-0 small">
                                        {{ number_format($property->prix, 0, ',', '.') }} MAD
                                    </p>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.properties.approve', $property->id_bien) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Approuver">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.properties.reject', $property->id_bien) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Rejeter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                <p class="text-muted mb-0">Aucun bien en attente</p>
                            </div>
                            @endforelse
                            
                            @if($pendingProperties->count() > 0)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.properties') }}?statut=en_attente" class="btn btn-sm btn-outline-warning">
                                    Voir tous les biens en attente
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Statistiques Rapides</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Biens actifs
                                    <span class="badge bg-success rounded-pill">{{ $stats['active_properties'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Agences enregistrées
                                    <span class="badge bg-info rounded-pill">{{ $stats['agencies_count'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Utilisateurs actifs
                                    <span class="badge bg-primary rounded-pill">{{ $stats['total_users'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Messages non lus
                                    <span class="badge bg-warning rounded-pill">{{ $stats['messages_count'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
</style>
@endsection
