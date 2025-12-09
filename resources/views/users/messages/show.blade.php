@extends('layouts.app')

@section('title', 'عرض الرسالة')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- بطاقة الرسالة الرئيسية -->
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                <!-- رأس البطاقة مع معلومات المرسل -->
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle bg-white text-primary me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%;">
                            <i class="fas fa-user fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $message->nom }}</h5>
                            <small class="opacity-75">
                                <i class="fas fa-phone me-1"></i>{{ $message->telephone }}
                                @if($message->ville)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $message->ville }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                <!-- محتوى الرسالة -->
                <div class="card-body p-4">
                    <!-- معلومات إضافية -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">تاريخ الإرسال</small>
                                        <strong>{{ $message->created_at->format('d/m/Y') }}</strong>
                                        <small class="text-muted d-block">{{ $message->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-success me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">الحالة</small>
                                        <strong class="text-success">مقروءة</strong>
                                        <small class="text-muted d-block">تم العرض</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- العقار المعني -->
                    @if($message->bien)
                    <div class="property-info mb-4 p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home text-primary me-3 fa-2x"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-primary">العقار المعني</h6>
                                <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="text-decoration-none">
                                    <strong class="text-dark">{{ $message->bien->titre }}</strong>
                                </a>
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>{{ $message->bien->prix }} درهم
                                        @if($message->bien->type_location)
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-key me-1"></i>{{ $message->bien->type_location }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i>عرض العقار
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- محتوى الرسالة -->
                    <div class="message-content">
                        <h6 class="mb-3 text-primary border-bottom pb-2">
                            <i class="fas fa-envelope-open-text me-2"></i>نص الرسالة
                        </h6>
                        <div class="message-text p-4 bg-light rounded-3 border-start border-primary border-4">
                            <p class="mb-0 fs-5 lh-base">{{ $message->contenu }}</p>
                        </div>
                    </div>
                </div>

                <!-- أزرار العمل -->
                <div class="card-footer bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.messages.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>العودة للرسائل
                            </a>
                            @if($message->bien)
                            <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="btn btn-outline-primary">
                                <i class="fas fa-home me-1"></i>عرض العقار
                            </a>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success" onclick="markAsRead({{ $message->id_message }})">
                                <i class="fas fa-check me-1"></i>تحديد كمقروءة
                            </button>
                            <form action="{{ route('users.messages.destroy', $message->id_message) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- رسائل أخرى من نفس المرسل -->
            @php
                $otherMessages = \App\Models\Message::where('recepteur_id', auth()->user()->id_user)
                    ->where('nom', $message->nom)
                    ->where('telephone', $message->telephone)
                    ->where('id_message', '!=', $message->id_message)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            @endphp

            @if($otherMessages->count() > 0)
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i>رسائل أخرى من {{ $message->nom }}
                    </h6>
                </div>
                <div class="card-body p-0">
                    @foreach($otherMessages as $otherMessage)
                    <div class="border-bottom p-3 hover-bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="mb-1">{{ Str::limit($otherMessage->contenu, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $otherMessage->created_at->diffForHumans() }}
                                    @if($otherMessage->bien)
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-home me-1"></i>{{ $otherMessage->bien->titre }}
                                    @endif
                                </small>
                            </div>
                            <a href="{{ route('users.messages.show', $otherMessage->id_message) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-circle {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.message-content .border-primary {
    border-color: #667eea !important;
}

.message-text {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.7;
}

.hover-bg-light:hover {
    background-color: #f8f9fa !important;
    transition: background-color 0.2s ease;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.card-header {
    border-bottom: none;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحديث عدد الإشعارات في الشريط العلوي
    const notificationBadge = document.querySelector('.navbar .fa-bell .badge');
    if (notificationBadge) {
        const currentCount = parseInt(notificationBadge.textContent) || 0;
        if (currentCount > 0) {
            const newCount = currentCount - 1;
            if (newCount > 0) {
                notificationBadge.textContent = newCount;
            } else {
                notificationBadge.style.display = 'none';
            }
        }
    }
});

function markAsRead(messageId) {
    fetch(`/messages/${messageId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إظهار رسالة نجاح
            showAlert('تم تحديث حالة الرسالة بنجاح!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ أثناء تحديث الرسالة', 'error');
    });
}

function showAlert(message, type) {
    // يمكنك استخدام مكتبة مثل SweetAlert أو Toast
    alert(message);
}
</script>
@endsection
