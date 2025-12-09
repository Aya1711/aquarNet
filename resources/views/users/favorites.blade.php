@extends('layouts.app')

@section('title', 'Biens favoris')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Mon compte</a></li>
            <li class="breadcrumb-item active">Favoris</li>
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
                    <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Biens favoris</h5>
                    <span class="badge bg-light text-dark">
                        {{ $favorites->total() }} bien(s)
                    </span>
                </div>
                <div class="card-body">
                    @if($favorites->count() > 0)
                    <div class="row">
                        @foreach($favorites as $favorite)
                        @php $property = $favorite->bien; @endphp
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card property-card h-100">
                                @if($property->images->count() > 0)
                                <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                     class="card-img-top" alt="{{ $property->titre }}" 
                                     style="height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('images/default-property.jpg') }}" 
                                     class="card-img-top" alt="Image par défaut"
                                     style="height: 200px; object-fit: cover;">
                                @endif
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $property->categorie == 'vente' ? 'success' : 'primary' }}">
                                            {{ $property->categorie == 'vente' ? 'Vente' : 'Location' }}
                                        </span>
                                        <span class="badge bg-secondary">{{ $property->type }}</span>
                                    </div>
                                    
                                    <h5 class="card-title">{{ Str::limit($property->titre, 50) }}</h5>
                                    
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $property->ville }}
                                    </p>
                                    
                                    <div class="property-details mb-3">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <small class="text-muted">Surface</small>
                                                <div><strong>{{ $property->surface }} m²</strong></div>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Chambres</small>
                                                <div><strong>{{ $property->chambres ?? '-' }}</strong></div>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Salles de bain</small>
                                                <div><strong>{{ $property->salles_bain ?? '-' }}</strong></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="text-primary mb-0">
                                            {{ number_format($property->prix, 0, ',', '.') }} MAD
                                        </h5>
                                        <small class="text-muted">
                                            {{ $property->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            @if($property->agence)
                                            <i class="fas fa-building me-1"></i> {{ $property->agence->nom_agence }}
                                            @else
                                            <i class="fas fa-user me-1"></i> Propriétaire particulier
                                            @endif
                                        </small>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('properties.show', $property->id_bien) }}" 
                                               class="btn btn-outline-primary">
                                                Détails
                                            </a>
                                            <form action="{{ route('user.favorites.remove', $property->id_bien) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        title="Retirer des favoris">
                                                    <i class="fas fa-heart-broken"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($favorites->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $favorites->links() }}
                    </div>
                    @endif
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun bien dans les favoris</h5>
                        <p class="text-muted">Vous pouvez ajouter vos biens préférés pour y revenir plus tard.</p>
                        <a href="{{ route('properties.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Explorer les biens
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
