@extends('layouts.app')

@section('title', 'Recherche avancée')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">Biens immobiliers</a></li>
            <li class="breadcrumb-item active">Recherche avancée</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Formulaire de recherche -->
        <div class="col-md-4">
            <div class="card shadow sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Recherche avancée</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('properties.index') }}" method="GET" id="advancedSearchForm">
                        <!-- Type d'opération -->
                        <div class="mb-3">
                            <label class="form-label">Type d'opération</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="categorie" id="vente" value="vente" 
                                       {{ request('categorie') == 'vente' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="vente">Vente</label>

                                <input type="radio" class="btn-check" name="categorie" id="location" value="location"
                                       {{ request('categorie') == 'location' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="location">Location</label>

                                <input type="radio" class="btn-check" name="categorie" id="all_cat" value="" 
                                       {{ !request('categorie') ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="all_cat">Tous</label>
                            </div>
                        </div>

                        <!-- Type de bien -->
                        <div class="mb-3">
                            <label class="form-label">Type de bien</label>
                            <select class="form-select" name="type">
                                <option value="">Tous les types</option>
                                <option value="appartement" {{ request('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="maison" {{ request('type') == 'maison' ? 'selected' : '' }}>Maison</option>
                                <option value="villa" {{ request('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="terrain" {{ request('type') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                <option value="local" {{ request('type') == 'local' ? 'selected' : '' }}>Local commercial</option>
                                <option value="bureau" {{ request('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                            </select>
                        </div>

                        <!-- Ville -->
                        <div class="mb-3">
                            <label class="form-label">Ville</label>
                            <input type="text" class="form-control" name="ville" value="{{ request('ville') }}" 
                                   placeholder="Nom de la ville">
                        </div>

                        <!-- Plage de prix -->
                        <div class="mb-3">
                            <label class="form-label">Plage de prix (MAD)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="prix_min" 
                                           value="{{ request('prix_min') }}" placeholder="Min">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="prix_max" 
                                           value="{{ request('prix_max') }}" placeholder="Max">
                                </div>
                            </div>
                        </div>

                        <!-- Plage de surface -->
                        <div class="mb-3">
                            <label class="form-label">Plage de surface (m²)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="surface_min" 
                                           value="{{ request('surface_min') }}" placeholder="Min">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="surface_max" 
                                           value="{{ request('surface_max') }}" placeholder="Max">
                                </div>
                            </div>
                        </div>

                        <!-- Nombre de chambres -->
                        <div class="mb-3">
                            <label class="form-label">Nombre de chambres</label>
                            <select class="form-select" name="chambres">
                                <option value="">Toutes</option>
                                <option value="1" {{ request('chambres') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('chambres') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('chambres') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('chambres') == '4' ? 'selected' : '' }}>4+</option>
                                <option value="5" {{ request('chambres') == '5' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        <!-- Caractéristiques -->
                        <div class="mb-3">
                            <label class="form-label">Caractéristiques</label>
                            <div class="row">
                                @php
                                    $features = ['Piscine', 'Jardin', 'Garage', 'Climatisation', 'Internet', 'Cuisine équipée'];
                                @endphp
                                @foreach($features as $feature)
                                <div class="col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="features[]" value="{{ $feature }}" 
                                               id="feature_{{ $loop->index }}"
                                               {{ in_array($feature, request('features', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_{{ $loop->index }}">
                                            {{ $feature }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                            <a href="{{ route('properties.advanced-search') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh me-2"></i>Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Résultats -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Résultats de la recherche avancée</h2>
                <div class="btn-group">
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>Vue classique
                    </a>
                </div>
            </div>

            <!-- Filtres actifs -->
            @if(request()->anyFilled(['type', 'categorie', 'ville', 'prix_min', 'prix_max', 'surface_min', 'surface_max', 'chambres']))
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title">Filtres actifs :</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if(request('categorie'))
                        <span class="badge bg-primary">
                            {{ request('categorie') == 'vente' ? 'Vente' : 'Location' }}
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeFilter('categorie')"></button>
                        </span>
                        @endif

                        @if(request('type'))
                        <span class="badge bg-secondary">
                            {{ request('type') }}
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeFilter('type')"></button>
                        </span>
                        @endif

                        @if(request('ville'))
                        <span class="badge bg-info">
                            {{ request('ville') }}
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeFilter('ville')"></button>
                        </span>
                        @endif

                        @if(request('prix_min') || request('prix_max'))
                        <span class="badge bg-warning text-dark">
                            Prix : 
                            {{ request('prix_min') ? request('prix_min') : '0' }} - 
                            {{ request('prix_max') ? request('prix_max') : '∞' }}
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removePriceFilter()"></button>
                        </span>
                        @endif

                        @if(request('surface_min') || request('surface_max'))
                        <span class="badge bg-success">
                            Surface : 
                            {{ request('surface_min') ? request('surface_min') : '0' }} - 
                            {{ request('surface_max') ? request('surface_max') : '∞' }} m²
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeSurfaceFilter()"></button>
                        </span>
                        @endif

                        @if(request('chambres'))
                        <span class="badge bg-danger">
                            {{ request('chambres') }}+ chambres
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeFilter('chambres')"></button>
                        </span>
                        @endif

                        @if(request('features'))
                        @foreach(request('features') as $feature)
                        <span class="badge bg-dark">
                            {{ $feature }}
                            <button type="button" class="btn-close btn-close-white ms-1" 
                                    onclick="removeFeature('{{ $feature }}')"></button>
                        </span>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Contenu des résultats -->
            <div id="searchResults">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Utilisez les critères de recherche pour trouver des biens</h5>
                    <p class="text-muted">Choisissez vos critères et cliquez sur "Rechercher" pour voir les biens correspondants.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('advancedSearchForm');
    const formInputs = form.querySelectorAll('input, select');
    
    formInputs.forEach(input => {
        input.addEventListener('change', performSearch);
    });

    if (window.location.search) {
        performSearch();
    }
});

function performSearch() {
    const form = document.getElementById('advancedSearchForm');
    const formData = new FormData(form);
    const searchParams = new URLSearchParams(formData);

    if (searchParams.toString()) {
        fetch(`{{ route('properties.index') }}?${searchParams.toString()}&ajax=1`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('searchResults').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('searchResults').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Une erreur est survenue lors de la recherche. Veuillez réessayer.
                    </div>
                `;
            });
    }
}

function removeFilter(filterName) {
    const url = new URL(window.location.href);
    url.searchParams.delete(filterName);
    window.location.href = url.toString();
}

function removePriceFilter() {
    const url = new URL(window.location.href);
    url.searchParams.delete('prix_min');
    url.searchParams.delete('prix_max');
    window.location.href = url.toString();
}

function removeSurfaceFilter() {
    const url = new URL(window.location.href);
    url.searchParams.delete('surface_min');
    url.searchParams.delete('surface_max');
    window.location.href = url.toString();
}

function removeFeature(feature) {
    const url = new URL(window.location.href);
    const features = url.searchParams.getAll('features[]');
    const updatedFeatures = features.filter(f => f !== feature);
    
    url.searchParams.delete('features[]');
    updatedFeatures.forEach(f => url.searchParams.append('features[]', f));
    
    window.location.href = url.toString();
}
</script>
@endsection
