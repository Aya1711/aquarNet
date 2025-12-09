@extends('layouts.app')

@section('title', 'Gestion des agences')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu principal</span>
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
                        <a class="nav-link active" href="{{ route('admin.agencies') }}">
                            <i class="fas fa-building me-2"></i>Agences
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des agences immobilières</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <span class="badge bg-primary fs-6">
                        {{ $agencies->total() }} agence(s)
                    </span>
                </div>
            </div>

            <!-- Quick stats -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total des agences</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agencies->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
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
                                        Biens actifs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agencies->sum('active_properties') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
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
                                        Agences par ville</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agencies->pluck('ville')->unique()->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                        Total des biens</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agencies->sum('properties_count') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agency table -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-building me-2"></i>Liste des agences immobilières</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Agence</th>
                                    <th>Ville</th>
                                    <th>Propriétaire</th>
                                    <th>Biens</th>
                                    <th>Actifs</th>
                                    <th>Date d'inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agencies as $agency)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($agency->logo)
                                            <img src="{{ asset('storage/' . $agency->logo) }}" 
                                                 class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            @else
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-building text-white"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $agency->nom_agence }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $agency->adresse }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $agency->ville }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $agency->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $agency->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <h5 class="text-primary mb-0">{{ $agency->properties_count }}</h5>
                                            <small class="text-muted">Bien</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <h5 class="text-success mb-0">{{ $agency->active_properties }}</h5>
                                            <small class="text-muted">Actif</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $agency->created_at->format('Y/m/d') }}
                                            <br>
                                            <span class="text-info">{{ $agency->created_at->diffForHumans() }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm">
                                            <a href="{{ route('agencies.show', $agency->id_agence) }}" 
                                               class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-eye me-1"></i>Voir
                                            </a>
                                            <a href="{{ route('admin.properties') }}?agence={{ $agency->id_agence }}" 
                                               class="btn btn-outline-info mb-1">
                                                <i class="fas fa-home me-1"></i>Biens
                                            </a>
                                            <button type="button" class="btn btn-outline-warning mb-1" 
                                                    data-bs-toggle="modal" data-bs-target="#agencyModal{{ $agency->id_agence }}">
                                                <i class="fas fa-info-circle me-1"></i>Détails
                                            </button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="agencyModal{{ $agency->id_agence }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Détails de l'agence</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                @if($agency->logo)
                                                                <img src="{{ asset('storage/' . $agency->logo) }}" 
                                                                     class="rounded-circle mb-3" 
                                                                     style="width: 120px; height: 120px; object-fit: cover;">
                                                                @else
                                                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                                                                     style="width: 120px; height: 120px;">
                                                                    <i class="fas fa-building fa-3x text-white"></i>
                                                                </div>
                                                                @endif
                                                                <h4>{{ $agency->nom_agence }}</h4>
                                                                <p class="text-muted">{{ $agency->ville }}</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h6 class="border-bottom pb-2">Informations de l'agence</h6>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th width="30%">Nom de l'agence:</th>
                                                                        <td>{{ $agency->nom_agence }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Adresse:</th>
                                                                        <td>{{ $agency->adresse }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Ville:</th>
                                                                        <td>{{ $agency->ville }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Date d'inscription:</th>
                                                                        <td>{{ $agency->created_at->format('Y/m/d') }}</td>
                                                                    </tr>
                                                                </table>

                                                                <h6 class="border-bottom pb-2 mt-4">Informations du propriétaire</h6>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th width="30%">Nom:</th>
                                                                        <td>{{ $agency->user->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email:</th>
                                                                        <td>{{ $agency->user->email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Téléphone:</th>
                                                                        <td>{{ $agency->user->telephone ?? 'Non spécifié' }}</td>
                                                                    </tr>
                                                                </table>

                                                                <h6 class="border-bottom pb-2 mt-4">Statistiques</h6>
                                                                <div class="row text-center">
                                                                    <div class="col-4">
                                                                        <div class="h4 text-primary">{{ $agency->properties_count }}</div>
                                                                        <small class="text-muted">Total des biens</small>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="h4 text-success">{{ $agency->active_properties }}</div>
                                                                        <small class="text-muted">Biens actifs</small>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="h4 text-info">{{ $agency->years_experience }}</div>
                                                                        <small class="text-muted">Années d'expérience</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($agency->description)
                                                        <div class="mt-4">
                                                            <h6 class="border-bottom pb-2">Description de l'agence</h6>
                                                            <p class="text-muted">{{ $agency->description }}</p>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <a href="{{ route('agencies.show', $agency->id_agence) }}" class="btn btn-primary">
                                                            <i class="fas fa-external-link-alt me-1"></i>Voir la page
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Aucune agence trouvée</h5>
                                        <p class="text-muted">Aucune agence immobilière n'a encore été enregistrée.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($agencies->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $agencies->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Agencies by city -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Répartition des agences par ville</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $cities = $agencies->groupBy('ville')->map->count()->sortDesc();
                            @endphp
                            @foreach($cities->take(10) as $city => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <span>
                                    <i class="fas fa-city me-2 text-info"></i>
                                    {{ $city }}
                                </span>
                                <span class="badge bg-primary">{{ $count }} agence(s)</span>
                            </div>
                            @endforeach
                            @if($cities->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Et {{ $cities->count() - 10 }} autre(s) ville(s)</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Meilleures agences</h5>
                        </div>
                        <div class="card-body">
                            @foreach($agencies->sortByDesc('active_properties')->take(5) as $agency)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($agency->nom_agence, 20) }}</h6>
                                    <small class="text-muted">{{ $agency->ville }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="text-success fw-bold">{{ $agency->active_properties }}</div>
                                    <small class="text-muted">Biens actifs</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection
