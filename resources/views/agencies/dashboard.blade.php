@extends('layouts.app')

@section('title', 'Tableau de bord de l\'agence')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- الشريط الجانبي -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    @if($agency->logo)
                    <img src="{{ asset('storage/' . $agency->logo) }}" 
                         class="rounded-circle mb-3" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-building fa-2x text-white"></i>
                    </div>
                    @endif
                    <h6>{{ $agency->nom_agence }}</h6>
                    <small class="text-muted">{{ $agency->ville }}</small>
                </div>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu principal</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('agencies.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Gestion des propriétés</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('properties.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>Ajouter une propriété
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.properties') }}">
                            <i class="fas fa-home me-2"></i>Propriétés de l'agence
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Compte</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.profile') }}">
                            <i class="fas fa-user me-2"></i>Profil personnel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.messages') }}">
                            <i class="fas fa-envelope me-2"></i>Messages
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de bord de l'agence</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter une propriété
                    </a>
                </div>
            </div>

            <!-- الإحصائيات -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total des propriétés</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
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
                                        Propriétés actives</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        En attente de révision</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                        Vendu/Loué</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sold'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- العقارات الحديثة -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('latest_agency_properties') }}</h6>
                            <a href="{{ route('user.properties') }}" class="btn btn-sm btn-primary">{{ __('view_all') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('property') }}</th>
                                            <th>{{ __('type') }}</th>
                                            <th>{{ __('city') }}</th>
                                            <th>{{ __('price') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th>{{ __('actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($properties as $property)
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
                                            <td>{{ number_format($property->prix, 0, ',', '.') }} درهم</td>
                                            <td>
                                                @if($property->statut == 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                                @elseif($property->statut == 'disponible')
                                                <span class="badge bg-success">Actif</span>
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
                                                    <a href="{{ route('properties.edit', $property->id_bien) }}"
                                                       class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="fas fa-home fa-2x text-muted mb-3"></i>
                                                <p class="text-muted">Aucune propriété</p>
                                                <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm">
                                                    Ajouter la première propriété
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الرسائل الحديثة -->
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Derniers messages</h6>
                        </div>
                        <div class="card-body">
                            @forelse($recentMessages as $message)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ Str::limit($message->expediteur->name, 20) }}</h6>
                                    @if($message->bien)
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-home me-1"></i>
                                        {{ Str::limit($message->bien->titre, 25) }}
                                    </p>
                                    @endif
                                    <p class="text-muted small mb-1">
                                        {{ Str::limit($message->contenu, 50) }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $message->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <a href="{{ route('user.messages') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-envelope fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucun message</p>
                            </div>
                            @endforelse

                            @if($recentMessages->count() > 0)
                            <div class="text-center mt-3">
                                <a href="{{ route('user.messages') }}" class="btn btn-sm btn-outline-info">
                                    Voir tous les messages
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- معلومات سريعة -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Informations de l'agence</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Nom de l'agence:</span>
                                    <strong>{{ $agency->nom_agence }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Ville:</span>
                                    <strong>{{ $agency->ville }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Téléphone:</span>
                                    <strong>{{ $agency->user->telephone }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Email:</span>
                                    <strong>{{ $agency->user->email }}</strong>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('user.profile') }}" class="btn btn-outline-success btn-sm w-100">
                                    <i class="fas fa-edit me-1"></i>Modifier les informations
                                </a>
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