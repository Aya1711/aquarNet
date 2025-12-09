<!-- Carte d'information utilisateur -->
<div class="card shadow-sm mb-3 text-center">
    <div class="card-body">
        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 80px; height: 80px;">
            <i class="fas fa-user fa-2x text-white"></i>
        </div>
        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-2">
            <span class="badge bg-{{ Auth::user()->role == 'agence' ? 'success' : 'primary' }}">
                {{ Auth::user()->role == 'agence' ? 'Agence immobilière' : 'Particulier' }}
            </span>
        </p>
        <p class="text-muted small mb-0">
            <i class="fas fa-envelope me-1"></i>{{ Auth::user()->email }}
        </p>
    </div>
</div>

<!-- Liens utilisateur -->
<div class="card shadow-sm mb-3">
    <div class="list-group list-group-flush">
        <a href="{{ route('user.profile') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i>Profil
        </a>
        <a href="{{ route('user.properties') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('user.properties') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i>Mes biens
            <span class="badge bg-primary rounded-pill float-end">{{ $stats['total'] ?? 0 }}</span>
        </a>
        <a href="{{ route('user.favorites') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('user.favorites') ? 'active' : '' }}">
            <i class="fas fa-heart me-2"></i>Favoris
        </a>
        <a href="{{ route('users.messages.index') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('user.messages') ? 'active' : '' }}">
            <i class="fas fa-envelope me-2"></i>Messages
            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
            <span class="badge bg-danger rounded-pill float-end">{{ $unreadMessagesCount }}</span>
            @endif
        </a>
        <a href="{{ route('properties.create') }}" 
           class="list-group-item list-group-item-action">
            <i class="fas fa-plus-circle me-2"></i>Ajouter un bien
        </a>
    </div>
</div>

<!-- Bouton de déconnexion -->
<div class="card shadow-sm">
    <div class="list-group list-group-flush">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action text-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
            </button>
        </form>
    </div>
</div>
