@extends('layouts.app')

@section('title', __('properties_title'))

@section('content')
<div class="container">
    <div class="row">
        <!-- شريط التصفية -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-filter me-2"></i>{{ __('filter_search') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('properties.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">{{ __('operation_type') }}</label>
                            <select class="form-select" name="categorie">
                                <option value="">{{ __('all') }}</option>
                                <option value="vente" {{ request('categorie') == 'vente' ? 'selected' : '' }}>{{ __('sale') }}</option>
                                <option value="location" {{ request('categorie') == 'location' ? 'selected' : '' }}>{{ __('rent') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('property_type') }}</label>
                            <select class="form-select" name="type">
                                <option value="">{{ __('all') }}</option>
                                <option value="appartement" {{ request('type') == 'appartement' ? 'selected' : '' }}>{{ __('apartment') }}</option>
                                <option value="maison" {{ request('type') == 'maison' ? 'selected' : '' }}>{{ __('house') }}</option>
                                <option value="villa" {{ request('type') == 'villa' ? 'selected' : '' }}>{{ __('villa') }}</option>
                                <option value="terrain" {{ request('type') == 'terrain' ? 'selected' : '' }}>{{ __('land') }}</option>
                                <option value="local" {{ request('type') == 'local' ? 'selected' : '' }}>{{ __('commercial') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('city') }}</label>
                            <input type="text" class="form-control" name="ville" value="{{ request('ville') }}" placeholder="{{ __('city') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('max_price') }}</label>
                            <input type="number" class="form-control" name="prix_max" value="{{ request('prix_max') }}" placeholder="{{ __('max_price') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('min_area') }}</label>
                            <input type="number" class="form-control" name="surface_min" value="{{ request('surface_min') }}" placeholder="{{ __('min_area') }}">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('apply_filters') }}</button>
                            <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">{{ __('reset') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- إعلانات جانبية -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>{{ __('add_property_free') }}</h6>
                    <p class="text-muted small">{{ __('publish_easily') }}</p>
                    <a href="{{ route('properties.create') }}" class="btn btn-success btn-sm">{{ __('add_property') }}</a>
                </div>
            </div>
        </div>

        <!-- قائمة العقارات -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ __('available_properties') }}</h2>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3">{{ $properties->total() }} {{ __('properties_found') }}</span>
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('add_property') }}
                    </a>
                </div>
            </div>

            <!-- خيارات الترتيب -->
            <div class="card shadow-sm mb-4">
                <div class="card-body py-2">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted">{{ __('sort_by') }}:</span>
                            <div class="btn-group ms-2">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                                   class="btn btn-sm btn-outline-secondary {{ request('sort', 'newest') == 'newest' ? 'active' : '' }}">
                                    {{ __('newest') }}
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}"
                                   class="btn btn-sm btn-outline-secondary {{ request('sort') == 'price_low' ? 'active' : '' }}">
                                    {{ __('price_low') }}
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}"
                                   class="btn btn-sm btn-outline-secondary {{ request('sort') == 'price_high' ? 'active' : '' }}">
                                    {{ __('price_high') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary active">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- شبكة العقارات -->
            @if($properties->count() > 0)
            <div class="row">
                @foreach($properties as $property)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card property-card h-100">
                        @if($property->images->count() > 0)
                        <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                             class="card-img-top" alt="{{ $property->titre }}" 
                             style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default-property.jpg') }}"
                             class="card-img-top" alt="{{ __('default_image') }}"
                             style="height: 200px; object-fit: cover;">
                        @endif
                        
                        <!-- شارة العقار المميز -->
                        @if($property->is_featured)
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-warning">
                                <i class="fas fa-star me-1"></i>{{ __('featured') }}
                            </span>
                        </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-{{ $property->categorie == 'vente' ? 'success' : 'primary' }}">
                                    {{ $property->categorie == 'vente' ? __('sale') : __('rent') }}
                                </span>
                                <span class="badge bg-secondary">{{ __($property->type) }}</span>
                            </div>
                            
                            <h5 class="card-title">{{ Str::limit($property->titre, 50) }}</h5>
                            
                            <p class="card-text text-muted small mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $property->ville }}, {{ $property->adresse }}
                            </p>
                            
                            <div class="property-details mb-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted">{{ __('area') }}</small>
                                        <div><strong>{{ $property->surface }} {{ __('sqm') }}</strong></div>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">{{ __('bedrooms') }}</small>
                                        <div><strong>{{ $property->chambres ?? '-' }}</strong></div>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted">{{ __('bathrooms') }}</small>
                                        <div><strong>{{ $property->salles_bain ?? '-' }}</strong></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="text-primary mb-0">
                                    {{ number_format($property->prix, 0, ',', '.') }} {{ __('currency') }}
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
                                    <i class="fas fa-user me-1"></i> {{ __('individual_owner') }}
                                    @endif
                                </small>
                                <a href="{{ route('properties.show', $property->id_bien) }}"
                                   class="btn btn-sm btn-primary">
                                    {{ __('details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- الترقيم -->
            <div class="d-flex justify-content-center mt-4">
                {{ $properties->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-home fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">{{ __('no_properties_available') }}</h4>
                <p class="text-muted">{{ __('no_properties_found') }}</p>
                <a href="{{ route('properties.index') }}" class="btn btn-primary">{{ __('view_all_properties') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection