@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Mon compte</a></li>
            <li class="breadcrumb-item active">Messages</li>
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
                    <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Messages</h5>
                    <span class="badge bg-light text-dark">
                        {{ $messages->total() }} message(s)
                    </span>
                </div>

                <div class="card-body p-0">
                    @forelse($messages as $message)
                    <div class="message-item border-bottom p-4 {{ !$message->lu ? 'bg-light' : '' }}">
                        <div class="row align-items-start">
                            <div class="col-md-8">
                                <div class="d-flex align-items-start mb-2">
                                    @if(!$message->lu)
                                        <span class="badge bg-warning me-2">Nouveau</span>
                                    @endif
                                    <h6 class="mb-0">
                                        {{ $message->nom ?? ($message->expediteur->name ?? 'Visiteur') }}
                                    </h6>
                                </div>

                                @if($message->bien)
                                    <div class="mb-2">
                                        <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="text-decoration-none">
                                            <i class="fas fa-home me-1 text-primary"></i>
                                            <strong>{{ $message->bien->titre }}</strong>
                                        </a>
                                    </div>
                                @endif

                                <p class="text-muted mb-2">{{ Str::limit($message->contenu, 150) }}</p>

                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $message->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <div class="col-md-4 text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('users.messages.show', $message->id_message) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('users.messages.destroy', $message->id_message) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                                onclick="return confirm('Voulez-vous supprimer ce message ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fenêtre modale pour détails du message -->
                    <div class="modal fade" id="messageModal{{ $message->id_message }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Détails du message</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Expéditeur :</strong>
                                            <p class="mb-1">
                                                {{ $message->nom ?? ($message->expediteur->name ?? 'Visiteur') }}
                                            </p>

                                            @if(!empty($message->telephone))
                                                <small class="text-muted d-block"><i class="fas fa-phone me-1"></i> {{ $message->telephone }}</small>
                                            @endif

                                            @if(!empty($message->ville))
                                                <small class="text-muted d-block"><i class="fas fa-map-marker-alt me-1"></i> {{ $message->ville }}</small>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <small class="text-muted">
                                                {{ $message->created_at->format('Y/m/d H:i') }}
                                            </small>
                                        </div>
                                    </div>

                                    @if($message->bien)
                                        <div class="alert alert-info mb-3">
                                            <i class="fas fa-home me-2"></i>
                                            <strong>Bien :</strong>
                                            <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="text-decoration-none">
                                                {{ $message->bien->titre }}
                                            </a>
                                        </div>
                                    @endif

                                    <div class="message-content bg-light p-3 rounded">
                                        <h6>Texte du message :</h6>
                                        <p class="mb-0" style="white-space: pre-line;">{{ $message->contenu }}</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if($message->bien)
                                        <a href="{{ route('properties.show', $message->bien->id_bien) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Voir le bien
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun message</h5>
                            <p class="text-muted">Vous n'avez reçu aucun message pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($messages->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $messages->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.message-item:hover {
    background-color: #f8f9fa !important;
}
.message-content {
    max-height: 300px;
    overflow-y: auto;
}
</style>
@endsection
