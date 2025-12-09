@extends('layouts.app')

@section('title', 'Ajouter un nouveau bien immobilier')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête de la page -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Ajouter un nouveau bien
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}" class="text-decoration-none">Biens immobiliers</a></li>
                            <li class="breadcrumb-item active">Ajouter un nouveau bien</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xxl-10 col-lg-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête de la carte -->
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-home me-2"></i>
                            Formulaire d'ajout d'un bien immobilier
                        </h4>
                        <span class="badge bg-white text-primary fs-6">Étape par étape</span>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" id="propertyForm" class="needs-validation" novalidate>
                        @csrf

                        <!-- Barre de progression -->
                        <div class="progress-steps mb-5">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <div class="step-icon">1</div>
                                    <span class="step-label">Informations de base</span>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-icon">2</div>
                                    <span class="step-label">Prix et localisation</span>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-icon">3</div>
                                    <span class="step-label">Caractéristiques</span>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-icon">4</div>
                                    <span class="step-label">Photos</span>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 1 : Informations de base -->
                        <div class="step-content active" data-step="1">
                            <div class="section-header mb-4">
                                <h5 class="section-title">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Informations de base
                                </h5>
                                <p class="text-muted mb-0">Entrez les informations de base du bien</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                               id="titre" name="titre" value="{{ old('titre') }}" 
                                               placeholder="Entrez le titre du bien" required>
                                        <label for="titre">Titre du bien <span class="text-danger">*</span></label>
                                        @error('titre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('type') is-invalid @enderror" 
                                                id="type" name="type" required>
                                            <option value="">Sélectionnez le type de bien</option>
                                            <option value="appartement" {{ old('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                            <option value="maison" {{ old('type') == 'maison' ? 'selected' : '' }}>Maison</option>
                                            <option value="villa" {{ old('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                            <option value="terrain" {{ old('type') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                            <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local commercial</option>
                                            <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                            <option value="ferme" {{ old('type') == 'ferme' ? 'selected' : '' }}>Ferme</option>
                                        </select>
                                        <label for="type">Type de bien <span class="text-danger">*</span></label>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('categorie') is-invalid @enderror" 
                                                id="categorie" name="categorie" required>
                                            <option value="">Sélectionnez le type de transaction</option>
                                            <option value="vente" {{ old('categorie') == 'vente' ? 'selected' : '' }}>Vente</option>
                                            <option value="location" {{ old('categorie') == 'location' ? 'selected' : '' }}>Location</option>
                                        </select>
                                        <label for="categorie">Type de transaction <span class="text-danger">*</span></label>
                                        @error('categorie')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if(Auth::user()->isAgence() && Auth::user()->agence)
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control bg-light" 
                                                   value="{{ Auth::user()->agence->nom_agence }}" readonly>
                                            <input type="hidden" name="agence_id" value="{{ Auth::user()->agence->id_agence }}">
                                            <label>Agence</label>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->isAdmin())
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="agence_id" name="agence_id">
                                                <option value="">Sans agence</option>
                                                @foreach($agences as $agence)
                                                    <option value="{{ $agence->id_agence }}" {{ old('agence_id') == $agence->id_agence ? 'selected' : '' }}>
                                                        {{ $agence->nom_agence }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="agence_id">Agence</label>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="step-actions mt-5">
                                <button type="button" class="btn btn-primary next-step" data-next="2">
                                    Suivant <i class="fas fa-arrow-left ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Étape 2 : Prix et localisation -->
                        <div class="step-content" data-step="2">
                            <div class="section-header mb-4">
                                <h5 class="section-title">
                                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                                    Prix et localisation
                                </h5>
                                <p class="text-muted mb-0">Définissez le prix et l'emplacement du bien</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control @error('prix') is-invalid @enderror" 
                                               id="prix" name="prix" value="{{ old('prix') }}" 
                                               min="0" step="0.01" placeholder="Entrez le prix" required>
                                        <label for="prix">Prix (MAD) <span class="text-danger">*</span></label>
                                        @error('prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control @error('surface') is-invalid @enderror" 
                                               id="surface" name="surface" value="{{ old('surface') }}" 
                                               min="0" step="0.01" placeholder="Entrez la surface" required>
                                        <label for="surface">Surface (m²) <span class="text-danger">*</span></label>
                                        @error('surface')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('ville') is-invalid @enderror" 
                                               id="ville" name="ville" value="{{ old('ville') }}" 
                                               placeholder="Entrez la ville" required>
                                        <label for="ville">Ville <span class="text-danger">*</span></label>
                                        @error('ville')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                                               id="adresse" name="adresse" value="{{ old('adresse') }}" 
                                               placeholder="Entrez l'adresse complète" required>
                                        <label for="adresse">Adresse complète <span class="text-danger">*</span></label>
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="step-actions mt-5">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">
                                    <i class="fas fa-arrow-right me-2"></i> Précédent
                                </button>
                                <button type="button" class="btn btn-primary next-step" data-next="3">
                                    Suivant <i class="fas fa-arrow-left ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Étape 3 : Caractéristiques -->
                        <div class="step-content" data-step="3">
                            <div class="section-header mb-4">
                                <h5 class="section-title">
                                    <i class="fas fa-list-alt text-warning me-2"></i>
                                    Caractéristiques et commodités
                                </h5>
                                <p class="text-muted mb-0">Définissez les caractéristiques et commodités du bien</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control @error('chambres') is-invalid @enderror" 
                                               id="chambres" name="chambres" value="{{ old('chambres') }}" 
                                               min="0" placeholder="Nombre de chambres">
                                        <label for="chambres">Nombre de chambres</label>
                                        @error('chambres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control @error('salles_bain') is-invalid @enderror" 
                                               id="salles_bain" name="salles_bain" value="{{ old('salles_bain') }}" 
                                               min="0" placeholder="Nombre de salles de bain">
                                        <label for="salles_bain">Nombre de salles de bain</label>
                                        @error('salles_bain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Commodités -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold mb-3">Commodités du bien</label>
                                    <div class="features-grid">
                                        @php
                                            $features = [
                                                'Piscine', 'Jardin', 'Garage', 'Sécurité', 'Climatisation', 'Télévision',
                                                'Internet', 'Cuisine équipée', 'Machine à laver', 'Sèche-linge', 'Chauffage',
                                                'Ensoleillé', 'Vue sur mer', 'Balcon', 'Débarras', 'Ascenseur'
                                            ];
                                        @endphp
                                        @foreach(array_chunk($features, 4) as $chunk)
                                            <div class="row g-3 mb-3">
                                                @foreach($chunk as $feature)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="features[]" value="{{ $feature }}" 
                                                                   id="feature_{{ $loop->parent->index }}_{{ $loop->index }}"
                                                                   {{ in_array($feature, old('features', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="feature_{{ $loop->parent->index }}_{{ $loop->index }}">
                                                                {{ $feature }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" 
                                                  placeholder="Entrez la description du bien" 
                                                  style="height: 150px" required>{{ old('description') }}</textarea>
                                        <label for="description">Description détaillée <span class="text-danger">*</span></label>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Entrez une description détaillée du bien incluant toutes les informations importantes.</div>
                                </div>
                            </div>

                            <div class="step-actions mt-5">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">
                                    <i class="fas fa-arrow-right me-2"></i> Précédent
                                </button>
                                <button type="button" class="btn btn-primary next-step" data-next="4">
                                    Suivant <i class="fas fa-arrow-left ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Étape 4 : Photos -->
                        <div class="step-content" data-step="4">
                            <div class="section-header mb-4">
                                <h5 class="section-title">
                                    <i class="fas fa-images text-info me-2"></i>
                                    Photos du bien
                                </h5>
                                <p class="text-muted mb-0">Téléchargez des photos claires du bien</p>
                            </div>

                            <!-- Zone de drag & drop -->
                            <div class="upload-area card border-dashed" id="dropArea">
                                <div class="card-body text-center p-5">
                                    <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted mb-2">Glissez et déposez les photos ici</h4>
                                    <p class="text-muted mb-4">Ou cliquez pour sélectionner les fichiers</p>
                                    <input type="file" class="d-none" id="images" name="images[]" multiple accept="image/*">
                                    <button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById('images').click()">
                                        <i class="fas fa-images me-2"></i>Sélectionner les photos
                                    </button>
                                    <div class="form-text mt-3">
                                        Vous pouvez télécharger jusqu'à 10 photos. Taille maximale par photo : 5MB. Formats autorisés : JPEG, PNG, JPG, GIF, WEBP.
                                    </div>
                                </div>
                            </div>

                            <!-- Infos sur les photos -->
                            <div class="upload-info mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <span id="imageCount" class="text-muted">0 photos téléchargées</span>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <span id="totalSize" class="text-muted">0 MB</span>
                                    </div>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div id="sizeProgress" class="progress-bar progress-bar-striped" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Prévisualisation des images -->
                            <div id="imagePreview" class="row mt-4 g-3"></div>

                            <!-- Messages d'erreur -->
                            @error('images')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                            @enderror

                            <div class="step-actions mt-5">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">
                                    <i class="fas fa-arrow-right me-2"></i> Précédent
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Ajouter le bien
                                </button>
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
    const steps = document.querySelectorAll('.step-content');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const stepIndicators = document.querySelectorAll('.step');

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const nextStep = btn.getAttribute('data-next');
            goToStep(nextStep);
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const prevStep = btn.getAttribute('data-prev');
            goToStep(prevStep);
        });
    });

    function goToStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

        stepIndicators.forEach(si => si.classList.remove('active'));
        for (let i = 0; i < step; i++) {
            stepIndicators[i].classList.add('active');
        }
    }

    // Gestion des images
    const dropArea = document.getElementById('dropArea');
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    const imageCount = document.getElementById('imageCount');
    const totalSize = document.getElementById('totalSize');
    const sizeProgress = document.getElementById('sizeProgress');

    function updateImages(files) {
        imagePreview.innerHTML = '';
        let count = 0;
        let size = 0;
        Array.from(files).forEach(file => {
            if(file.size <= 5*1024*1024){
                count++;
                size += file.size;
                const reader = new FileReader();
                reader.onload = e => {
                    const col = document.createElement('div');
                    col.className = 'col-md-3';
                    col.innerHTML = `<div class="card"><img src="${e.target.result}" class="card-img-top"></div>`;
                    imagePreview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
        imageCount.textContent = `${count} photo(s) téléchargée(s)`;
        totalSize.textContent = `${(size/1024/1024).toFixed(2)} MB`;
        sizeProgress.style.width = `${(size / (10*1024*1024) * 100).toFixed(2)}%`;
    }

    imageInput.addEventListener('change', () => updateImages(imageInput.files));
    dropArea.addEventListener('dragover', e => e.preventDefault());
    dropArea.addEventListener('drop', e => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        imageInput.files = files;
        updateImages(files);
    });
});
</script>
@endsection
