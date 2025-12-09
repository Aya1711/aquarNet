@extends('layouts.app')
@section('title', 'Accueil - Plateforme Immobilière')

@section('content')
<!-- home-->
<div class="hero-section position-relative">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8 mx-auto text-center text-white">
                <div class="hero-content">
                    <h1 class="hero-title animate__animated animate__fadeInDown">
                        <span class="text-warning">Trouvez</span> votre maison 
                        <span class="text-success">idéale</span> facilement
                    </h1>
                    <p class="hero-description animate__animated animate__fadeInUp">
                        Une plateforme immobilière complète réunissant les meilleures agences et propriétaires 
                        pour vous offrir une expérience de recherche fluide et sécurisée. Découvrez des milliers 
                        de biens à vendre ou à louer dans toutes les villes.
                    </p>
                    <div class="hero-buttons animate__animated animate__fadeInUp">
                        <a href="{{ route('properties.index') }}" class="btn btn-warning btn-lg me-3">
                            <i class="fas fa-search me-2"></i>
                            Commencez la recherche
                        </a>
                        <a href="{{ route('agencies.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-building me-2"></i>
                            Parcourir les agences
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <a href="#properties" class="scroll-down">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</div>

<!-- Section fonctionnalités -->
<div class="features-section py-5 bg-white">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">Pourquoi choisir notre plateforme ?</h2>
                <p class="section-subtitle">Nous vous offrons les meilleurs services immobiliers</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Sécurisé et fiable</h4>
                    <p class="text-muted">Toutes les agences et biens sont vérifiés et authentifiés</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Recherche avancée</h4>
                    <p class="text-muted">Des outils intelligents pour trouver exactement ce que vous cherchez</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Support complet</h4>
                    <p class="text-muted">Une équipe disponible 24/7 pour vous aider</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dernières propriétés -->
<div id="properties" class="properties-section py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="section-title">Dernières propriétés</h2>
                        <p class="section-subtitle">Découvrez les dernières annonces ajoutées sur la plateforme</p>
                    </div>
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-primary">
                        Voir toutes les propriétés
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($latestProperties as $property)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="property-card card h-100 shadow-sm border-0">
                    <div class="property-image position-relative">
                        @if($property->images->count() > 0)
                        <img src="{{ asset('storage/' . $property->images->first()->url_image) }}"
                             class="card-img-top" alt="{{ $property->titre }}" 
                             style="height: 250px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/bg.png') }}" 
                             class="card-img-top" alt="Image par défaut" 
                             style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="property-badge position-absolute top-0 start-0 m-3">
                            <span class="badge bg-{{ $property->categorie == 'vente' ? 'success' : 'primary' }}">
                                {{ $property->categorie == 'vente' ? 'Vente' : 'Location' }}
                            </span>
                        </div>
                        <div class="property-price position-absolute top-0 end-0 m-3">
                            <span class="badge bg-dark fs-6">
                                {{ number_format($property->prix, 0, ',', '.') }} MAD
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $property->titre }}</h5>
                        <p class="card-text text-muted mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            {{ $property->ville }}
                        </p>
                        <div class="property-features d-flex justify-content-between text-muted mb-3">
                            <span>
                                <i class="fas fa-vector-square me-1"></i>
                                {{ $property->surface }} m²
                            </span>
                            @if($property->nombre_chambres)
                            <span>
                                <i class="fas fa-bed me-1"></i>
                                {{ $property->nombre_chambres }} chambres
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="agency-info">
                                @if($property->agence)
                                <small class="text-muted">
                                    <i class="fas fa-building me-1"></i> 
                                    {{ $property->agence->nom_agence }}
                                </small>
                                @else
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i> 
                                    Propriétaire particulier
                                </small>
                                @endif
                            </div>
                            <a href="{{ route('properties.show', $property->id_bien) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Agences immobilières -->
<div class="agencies-section py-5 bg-white">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="section-title">Agences immobilières en vedette</h2>
                        <p class="section-subtitle">Collaborez avec les agences les plus fiables</p>
                    </div>
                    <a href="{{ route('agencies.index') }}" class="btn btn-outline-primary">
                        Voir toutes les agences
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            @foreach($featuredAgencies as $agency)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="agency-card card text-center h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="agency-logo mb-3">
                            @if($agency->logo)
                            <img src="{{ asset('storage/' . $agency->logo) }}" 
                                 class="rounded-circle" alt="{{ $agency->nom_agence }}" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-building fa-2x text-white"></i>
                            </div>
                            @endif
                        </div>
                        <h5 class="card-title fw-bold mb-2">{{ $agency->nom_agence }}</h5>
                        <p class="card-text text-muted mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ $agency->ville }}
                        </p>
                        <p class="card-text small text-muted mb-3">
                            {{ Str::limit($agency->description, 120) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pb-4">
                        <a href="{{ route('agencies.show', $agency->id_agence) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>
                            Voir l'agence
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for scroll indicator
    document.querySelector('.scroll-down').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#properties').scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
@endsection
