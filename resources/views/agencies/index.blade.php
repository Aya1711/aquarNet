@extends('layouts.app')

@section('title', 'Agences immobilières')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Agences immobilières</h2>
                <a href="{{ route('register.agency') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Enregistrer une agence
                </a>
            </div>
            <p class="text-muted">Découvrez les meilleures agences immobilières de confiance</p>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('agencies.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}" placeholder="Rechercher une agence...">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="ville"
                                       value="{{ request('ville') }}" placeholder="Ville">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des agences -->
    <div class="row">
        @foreach($agencies as $agency)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card agency-card h-100 shadow-sm">
                <div class="card-body text-center">
                    @if($agency->logo)
                    <img src="{{ asset('storage/' . $agency->logo) }}" 
                         class="rounded-circle mb-3" 
                         style="width: 100px; height: 100px; object-fit: cover;"
                         alt="{{ $agency->nom_agence }}">
                    @else
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 100px; height: 100px;">
                        <i class="fas fa-building fa-3x text-muted"></i>
                    </div>
                    @endif
                    
                    <h5 class="card-title">{{ $agency->nom_agence }}</h5>
                    
                    <p class="card-text text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $agency->ville }}
                    </p>
                    
                    <p class="card-text small text-muted mb-3">
                        {{ Str::limit($agency->description, 120) }}
                    </p>

                    <!-- Statistiques de l'agence -->
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="text-primary fw-bold">{{ $agency->properties_count }}</div>
                            <small class="text-muted">Propriétés</small>
                        </div>
                        <div class="col-4">
                            <div class="text-success fw-bold">{{ $agency->active_properties }}</div>
                            <small class="text-muted">Actives</small>
                        </div>
                        <div class="col-4">
                            <div class="text-info fw-bold">{{ $agency->years_experience }}</div>
                            <small class="text-muted">Années</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-grid gap-2">
                        <a href="{{ route('agencies.show', $agency->id_agence) }}" 
                           class="btn btn-outline-primary">
                            Voir l'agence
                        </a>
                        <a href="{{ route('properties.index', ['agence' => $agency->id_agence]) }}" 
                           class="btn btn-outline-secondary btn-sm">
                            Voir les propriétés de l'agence
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($agencies->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $agencies->links() }}
    </div>
    @endif

    <!-- Aucune agence trouvée -->
    @if($agencies->count() == 0)
    <div class="text-center py-5">
        <i class="fas fa-building fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Aucune agence immobilière</h4>
        <p class="text-muted">Aucune agence ne correspond à vos critères de recherche.</p>
        <a href="{{ route('agencies.index') }}" class="btn btn-primary">Voir toutes les agences</a>
    </div>
    @endif
</div>
@endsection
