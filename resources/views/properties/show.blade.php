@extends('layouts.app')

@section('title', $property->titre)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">{{ __('properties') }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($property->titre, 30) }}</li>
        </ol>
    </nav>

    <!-- رسالة النجاح -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- معرض الصور -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    @if($property->images->count() > 0)
                    <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($property->images as $key => $image)
                            <button type="button" data-bs-target="#propertyCarousel" 
                                    data-bs-slide-to="{{ $key }}" 
                                    class="{{ $key == 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($property->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->url_image) }}"
                                     class="d-block w-100"
                                     style="height: 400px; object-fit: cover;"
                                     alt="{{ $property->titre }}">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('previous') }}</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('next') }}</span>
                        </button>
                    </div>
                    @else
                    <img src="{{ asset('images/default-property.jpg') }}"
                         class="card-img-top" alt="{{ __('default_image') }}"
                         style="height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>

            <!-- الصور المصغرة -->
            @if($property->images->count() > 1)
            <div class="row g-2 mb-4">
                @foreach($property->images as $image)
                <div class="col-3">
                    <img src="{{ asset('storage/' . $image->url_image) }}"
                         class="img-thumbnail w-100"
                         style="height: 80px; object-fit: cover; cursor: pointer;"
                         onclick="showImage('{{ asset('storage/' . $image->url_image) }}')">
                </div>
                @endforeach
            </div>
            @endif

            <!-- معلومات العقار -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('property_info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>{{ __('operation_type') }}:</strong>
                            <span class="badge bg-{{ $property->categorie == 'vente' ? 'success' : 'primary' }} ms-2">
                                {{ $property->categorie == 'vente' ? __('sale') : __('rent') }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('property_type') }}:</strong> {{ $property->type }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>{{ __('area') }}:</strong> {{ $property->surface }} م²
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('price') }}:</strong>
                            <span class="text-primary fw-bold">
                                {{ number_format($property->prix, 0, ',', '.') }} {{ __('currency') }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>{{ __('bedrooms') }}:</strong> {{ $property->chambres ?? __('not_specified') }}
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('bathrooms') }}:</strong> {{ $property->salles_bain ?? __('not_specified') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong>{{ __('address') }}:</strong>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $property->adresse }}, {{ $property->ville }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الوصف -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ __('property_description') }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $property->description }}</p>
                </div>
            </div>

            <!-- الميزات -->
            @if($property->features)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ __('property_features') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach(json_decode($property->features) as $feature)
                        <div class="col-md-6 mb-2">
                            <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- الجانب الأيمن -->
        <div class="col-md-4">

            <!-- معلومات المعلن -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">{{ __('advertiser_info') }}</h5>
                </div>
                <div class="card-body text-center">
                    @if($property->agence)
                    <!-- إذا كانت الوكالة -->
                    @if($property->agence->logo)
                    <img src="{{ asset('storage/' . $property->agence->logo) }}"
                         class="rounded-circle mb-3"
                         style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-building fa-2x text-muted"></i>
                    </div>
                    @endif
                    <h5>{{ $property->agence->nom_agence }}</h5>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $property->agence->ville }}
                    </p>
                    <p class="small">{{ Str::limit($property->agence->description, 100) }}</p>
                    @else
                    <!-- إذا كان فرد -->
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                    <h5>{{ $property->user->name }}</h5>
                    <p class="text-muted">
                        <i class="fas fa-phone me-1"></i>
                        {{ $property->user->telephone }}
                    </p>
                    @endif

                    <!-- زر التواصل -->
                    <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fas fa-envelope me-2"></i>{{ __('contact_advertiser') }}
                    </button>

                    @if($property->agence)
                    <a href="{{ route('agencies.show', $property->agence->id_agence) }}"
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-building me-2"></i>{{ __('view_agency') }}
                    </a>
                    @endif
                </div>
            </div>

            <!-- الإجراءات السريعة -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('quick_actions') }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" id="favoriteBtn" onclick="toggleFavorite({{ $property->id_bien }})">
                            <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart me-2" id="favoriteIcon"></i>
                            <span id="favoriteText">{{ $isFavorite ? __('remove_from_favorites') : __('add_to_favorites') }}</span>
                        </button>
                        <button class="btn btn-outline-secondary" onclick="shareProperty()">
                            <i class="fas fa-share-alt me-2"></i>{{ __('share_property') }}
                        </button>
                        <button class="btn btn-outline-danger" onclick="reportProperty()">
                            <i class="fas fa-flag me-2"></i>{{ __('report_listing') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- عقارات مشابهة -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('similar_properties') }}</h6>
                </div>
                <div class="card-body">
                    @foreach($similarProperties as $similar)
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        @if($similar->images->count() > 0)
                        <img src="{{ asset('storage/' . $similar->images->first()->url_image) }}"
                             class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default-property.jpg') }}"
                             class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;"
                             alt="{{ __('default_image') }}">
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ Str::limit($similar->titre, 30) }}</h6>
                            <p class="text-muted small mb-1">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $similar->ville }}
                            </p>
                            <p class="text-primary mb-0 small">
                                {{ number_format($similar->prix, 0, ',', '.') }} {{ __('currency') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج التواصل -->
<div class="modal fade" id="contactModal" tabindex="-1" @if ($errors->any()) style="display:block;" @endif>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('contact_advertiser') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- عرض رسائل الخطأ --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form id="contactForm" method="POST" action="{{ route('messages.store') }}">
                    @csrf

                    <input type="hidden" name="bien_id" value="{{ $property->id_bien }}">
                    <input type="hidden" name="recepteur_id" value="{{ $property->user_id }}">

                    <div class="mb-3">
                        <label class="form-label">{{ __('full_name') }}</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('phone_number') }}</label>
                        <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('city') }}</label>
                        <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}">
                        @error('ville')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('message_content') }}</label>
                        <textarea class="form-control @error('contenu') is-invalid @enderror" name="contenu" rows="4">{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('send_message') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
// Pass translations to JavaScript
window.translations = {
    login_required_favorite: '{{ __('login_required_favorite') }}',
    error_updating_favorite: '{{ __('error_updating_favorite') }}',
    remove_from_favorites: '{{ __('remove_from_favorites') }}',
    add_to_favorites: '{{ __('add_to_favorites') }}',
    share_link: '{{ __('share_link') }}',
    report_thanks: '{{ __('report_thanks') }}'
};

// Pass authentication status to JavaScript
window.isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

function toggleFavorite(propertyId) {
    // Check if user is authenticated
    if (!window.isAuthenticated) {
        showToast(window.translations.login_required_favorite, 'error');
        return;
    }

    fetch('{{ route("properties.favorite", ":id") }}'.replace(':id', propertyId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (response.redirected) {
            // Handle redirect (likely to login page)
            showToast(window.translations.login_required_favorite, 'error');
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            const icon = document.getElementById('favoriteIcon');
            const text = document.getElementById('favoriteText');

            if (data.is_favorite) {
                icon.className = 'fas fa-heart me-2';
                text.textContent = window.translations.remove_from_favorites;
            } else {
                icon.className = 'far fa-heart me-2';
                text.textContent = window.translations.add_to_favorites;
            }

            // Show success message
            showToast(data.message, 'success');
        } else if (data) {
            showToast(data.message || window.translations.error_updating_favorite, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(window.translations.error_updating_favorite, 'error');
    });
}

function showToast(message, type) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(toast);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}

function shareProperty() {
    // مشاركة العقار
    if (navigator.share) {
        navigator.share({
            title: '{{ $property->titre }}',
            text: '{{ $property->description }}',
            url: window.location.href
        });
    } else {
        // Fallback
        alert(window.translations.share_link + window.location.href);
    }
}

function reportProperty() {
    // الإبلاغ عن الإعلان
    alert(window.translations.report_thanks);
}

function showImage(imageUrl) {
    // عرض صورة كبيرة
    window.open(imageUrl, '_blank');
}

// نموذج التواصل - إزالة منع الإرسال الافتراضي للسماح بإرسال البيانات
// الإرسال يتم عبر الخادم الآن
</script>
@endsection
