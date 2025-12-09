@extends('layouts.app')

@section('title', $agency->nom_agence)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">{{ __('agencies') }}</a></li>
            <li class="breadcrumb-item active">{{ $agency->nom_agence }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- معلومات الوكالة -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if($agency->logo)
                    <img src="{{ asset('storage/' . $agency->logo) }}" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;"
                         alt="{{ $agency->nom_agence }}">
                    @else
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-building fa-4x text-muted"></i>
                    </div>
                    @endif
                    
                    <h3>{{ $agency->nom_agence }}</h3>
                    
                    <p class="text-muted mb-3">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $agency->adresse }}, {{ $agency->ville }}
                    </p>

                    <!-- معلومات الاتصال -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <span>{{ $agency->user->telephone }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <span>{{ $agency->user->email }}</span>
                        </div>
                    </div>

                    <!-- إحصائيات -->
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="h5 text-primary mb-1">{{ $agency->biens_count }}</div>
                            <small class="text-muted">{{ __('total_properties') }}</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 text-success mb-1">{{ $agency->active_biens }}</div>
                            <small class="text-muted">{{ __('active_properties') }}</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 text-info mb-1">{{ $agency->years_experience }}</div>
                            <small class="text-muted">{{ __('years_experience') }}</small>
                        </div>
                    </div>

                    <!-- أزرار التواصل -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-envelope me-2"></i>{{ __('contact_agency') }}
                        </button>
                        <a href="{{ route('properties.index', ['agence' => $agency->id_agence]) }}"
                           class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>{{ __('view_agency_properties') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- ساعات العمل -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('working_hours') }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('monday_friday') }}</span>
                        <span>9:00 - 18:00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('saturday') }}</span>
                        <span>9:00 - 14:00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>{{ __('sunday') }}</span>
                        <span>{{ __('closed') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- محتوى الوكالة -->
        <div class="col-md-8">
            <!-- وصف الوكالة -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('about_agency') }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $agency->description }}</p>

                    <!-- المميزات -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>{{ __('trusted_properties') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>{{ __('competitive_prices') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>{{ __('continuous_support') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>{{ __('after_sales_service') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agency Properties -->
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('agency_properties') }}</h5>
                    <a href="{{ route('properties.index', ['agence' => $agency->id_agence]) }}"
                       class="btn btn-sm btn-outline-primary">
                        {{ __('view_all') }}
                    </a>
                </div>
                <div class="card-body">
                    @if($agency->biens && $agency->biens->count() > 0)
                    <div class="row">
                        @foreach($agency->biens->take(6) as $property)
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100">
                                @if($property->images->count() > 0)
                                <img src="{{ asset('storage/' . $property->images->first()->url_image) }}" 
                                     class="card-img-top" 
                                     style="height: 120px; object-fit: cover;"
                                     alt="{{ $property->titre }}">
                                @else
                                <img src="{{ asset('images/default-property.jpg') }}" 
                                     class="card-img-top" 
                                     style="height: 120px; object-fit: cover;"
                                     alt="صورة افتراضية">
                                @endif
                                
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($property->titre, 30) }}</h6>
                                    <p class="card-text small text-muted mb-1">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $property->ville }}
                                    </p>
                                    <p class="card-text text-primary mb-0 small">
                                        {{ number_format($property->prix, 0, ',', '.') }} درهم
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent py-2">
                                    <a href="{{ route('properties.show', $property->id_bien) }}"
                                       class="btn btn-sm btn-outline-primary w-100">
                                        {{ __('details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-home fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">{{ __('no_properties_available_agency') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج التواصل مع الوكالة -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('contact_with_agency') }} {{ $agency->nom_agence }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="agencyContactForm">
                    @csrf
                    <input type="hidden" name="agency_id" value="{{ $agency->id_agence }}">
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('your_name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('your_email') }}</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('your_phone') }}</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('subject') }}</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('your_message') }}</label>
                        <textarea class="form-control" name="message" rows="4" required></textarea>
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
document.getElementById('agencyContactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('{{ __('message_sent_success') }}');
    $('#contactModal').modal('hide');
});
</script>
@endsection
