@extends('layouts.app')

@section('title', 'Modifier le bien immobilier')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">Biens immobiliers</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.show', $property->id_bien) }}">{{ Str::limit($property->titre, 20) }}</a></li>
            <li class="breadcrumb-item active">Modifier le bien</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier le bien immobilier</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('properties.update', $property->id_bien) }}" method="POST" enctype="multipart/form-data" id="propertyForm">
                        @csrf
                        @method('PUT')

                        <!-- Informations de base -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Informations de base</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre du bien <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                       id="titre" name="titre" value="{{ old('titre', $property->titre) }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type de bien <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Sélectionnez le type de bien</option>
                                    <option value="appartement" {{ old('type', $property->type) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                    <option value="maison" {{ old('type', $property->type) == 'maison' ? 'selected' : '' }}>Maison</option>
                                    <option value="villa" {{ old('type', $property->type) == 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="terrain" {{ old('type', $property->type) == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                    <option value="local" {{ old('type', $property->type) == 'local' ? 'selected' : '' }}>Local commercial</option>
                                    <option value="bureau" {{ old('type', $property->type) == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                    <option value="ferme" {{ old('type', $property->type) == 'ferme' ? 'selected' : '' }}>Ferme</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="categorie" class="form-label">Type de transaction <span class="text-danger">*</span></label>
                                <select class="form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie" required>
                                    <option value="">Sélectionnez le type de transaction</option>
                                    <option value="vente" {{ old('categorie', $property->categorie) == 'vente' ? 'selected' : '' }}>Vente</option>
                                    <option value="location" {{ old('categorie', $property->categorie) == 'location' ? 'selected' : '' }}>Location</option>
                                </select>
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(Auth::user()->isAdmin())
                                <div class="col-md-6 mb-3">
                                    <label for="agence_id" class="form-label">Agence</label>
                                    <select class="form-select" id="agence_id" name="agence_id">
                                        <option value="">Sans agence</option>
                                        @foreach($agences as $agence)
                                            <option value="{{ $agence->id_agence }}" {{ old('agence_id', $property->agence_id) == $agence->id_agence ? 'selected' : '' }}>
                                                {{ $agence->nom_agence }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($property->agence_id)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agence</label>
                                    <input type="text" class="form-control" value="{{ $property->agence->nom_agence }}" readonly>
                                    <input type="hidden" name="agence_id" value="{{ $property->agence_id }}">
                                </div>
                            @endif
                        </div>

                        <!-- Prix et superficie -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Prix et superficie</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="prix" class="form-label">Prix (MAD) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('prix') is-invalid @enderror" 
                                       id="prix" name="prix" value="{{ old('prix', $property->prix) }}" min="0" step="0.01" required>
                                @error('prix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="surface" class="form-label">Surface (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('surface') is-invalid @enderror" 
                                       id="surface" name="surface" value="{{ old('surface', $property->surface) }}" min="0" step="0.01" required>
                                @error('surface')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Localisation</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ville') is-invalid @enderror" 
                                       id="ville" name="ville" value="{{ old('ville', $property->ville) }}" required>
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="adresse" class="form-label">Adresse complète <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                                       id="adresse" name="adresse" value="{{ old('adresse', $property->adresse) }}" required>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Caractéristiques -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Caractéristiques</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="chambres" class="form-label">Nombre de chambres</label>
                                <input type="number" class="form-control @error('chambres') is-invalid @enderror" 
                                       id="chambres" name="chambres" value="{{ old('chambres', $property->chambres) }}" min="0">
                                @error('chambres')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="salles_bain" class="form-label">Nombre de salles de bain</label>
                                <input type="number" class="form-control @error('salles_bain') is-invalid @enderror" 
                                       id="salles_bain" name="salles_bain" value="{{ old('salles_bain', $property->salles_bain) }}" min="0">
                                @error('salles_bain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Commodités -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Commodités du bien</h5>
                                <div class="row">
                                    @php
                                        $features = [
                                            'Piscine', 'Jardin', 'Garage', 'Sécurité', 'Climatisation', 'Télévision',
                                            'Internet', 'Cuisine équipée', 'Machine à laver', 'Sèche-linge', 'Chauffage',
                                            'Ensoleillé', 'Vue sur mer', 'Balcon', 'Débarras', 'Ascenseur'
                                        ];
                                        $currentFeatures = json_decode($property->features) ?: [];
                                    @endphp
                                    @foreach($features as $feature)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="features[]" value="{{ $feature }}" 
                                                       id="feature_{{ $loop->index }}"
                                                       {{ in_array($feature, old('features', $currentFeatures)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="feature_{{ $loop->index }}">
                                                    {{ $feature }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Description du bien</h5>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description détaillée <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="6" required>{{ old('description', $property->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Photos existantes -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Photos existantes</h5>
                                <div class="row">
                                    @foreach($property->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $image->url_image) }}" 
                                                 class="card-img-top" 
                                                 style="height: 150px; object-fit: cover;">
                                            <div class="card-body p-2 text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteImage({{ $image->id_image }})">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Ajouter de nouvelles photos -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Ajouter de nouvelles photos</h5>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Télécharger de nouvelles photos</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                           id="images" name="images[]" multiple accept="image/*">
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Vous pouvez télécharger plusieurs nouvelles photos. Taille maximale par photo : 2MB.
                                    </div>
                                </div>
                                
                                <!-- Aperçu des nouvelles photos -->
                                <div id="imagePreview" class="row mt-3"></div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('properties.show', $property->id_bien) }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>Annuler
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aperçu des nouvelles photos
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function() {
        imagePreview.innerHTML = '';
        
        if (this.files) {
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            </div>
                        `;
                        imagePreview.appendChild(col);
                    }
                    
                    reader.readAsDataURL(file);
                }
            });
        }
    });
});

function deleteImage(imageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        fetch(`/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Une erreur est survenue lors de la suppression de l\'image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de la suppression de l\'image');
        });
    }
}
</script>
@endsection
