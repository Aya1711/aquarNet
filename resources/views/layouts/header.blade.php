<header class="bg-white shadow-sm sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">

                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-home me-2"></i>
                    Plateforme Immobilière
                </a>

                <!-- Bouton menu mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenu du menu -->
                <div class="collapse navbar-collapse" id="navbarMain">

                    <!-- Menu principal -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>Accueil
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('properties*') ? 'active' : '' }}"
                               href="{{ route('properties.index') }}">
                                <i class="fas fa-building me-1"></i>Biens immobiliers
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('agencies*') ? 'active' : '' }}"
                               href="{{ route('agencies.index') }}">
                                <i class="fas fa-city me-1"></i>Agences
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-plus-circle me-1"></i>Ajouter un bien
                            </a>
                            <ul class="dropdown-menu">
                                @auth
                                    <li>
                                        <a class="dropdown-item" href="{{ route('properties.create') }}">
                                            <i class="fas fa-home me-2"></i>Ajouter un bien
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </li>
                    </ul>

                    <!-- Zone utilisateur -->
                    <ul class="navbar-nav">
                        @auth
                            @if(Auth::user()->role !== 'admin')

                                <!-- Notifications -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-bell"></i>
                                        @if(auth()->user()->messagesRecus()->unread()->count() > 0)
                                            <span class="badge bg-danger position-absolute top-0 start-0 translate-middle"
                                                  style="font-size: 0.6em;">
                                                {{ auth()->user()->messagesRecus()->unread()->count() }}
                                            </span>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><h6 class="dropdown-header">Notifications</h6></li>

                                        @forelse(auth()->user()->messagesRecus()->unread()->take(5)->get() as $message)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('users.messages.index') }}">
                                                    <small>{{ Str::limit($message->contenu, 30) }}</small><br>
                                                    <small class="text-muted">
                                                        {{ $message->created_at->diffForHumans() }}
                                                    </small>
                                                </a>
                                            </li>
                                        @empty
                                            <li>
                                                <a class="dropdown-item text-muted">Aucune nouvelle notification</a>
                                            </li>
                                        @endforelse

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-center"
                                               href="{{ route('users.messages.index') }}">
                                                Voir toutes les notifications
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Favoris -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.favorites') }}">
                                        <i class="fas fa-heart"></i>
                                        @if(auth()->user()->favoris()->count() > 0)
                                            <span class="badge bg-danger" style="font-size: 0.6em;">
                                                {{ auth()->user()->favoris()->count() }}
                                            </span>
                                        @endif
                                    </a>
                                </li>

                                <!-- Compte -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                        <span class="badge bg-primary ms-1" style="font-size: 0.6em;">
                                            {{ Auth::user()->role === 'agence' ? 'Agence' : 'Particulier' }}
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                                Mon profil
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.properties') }}">
                                                Mes biens
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="dropdown-item text-danger">
                                                    Déconnexion
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>

                            @else
                                <!-- Admin -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-danger fw-bold" data-bs-toggle="dropdown">
                                        {{ Auth::user()->name }} (Administrateur)
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/') }}">Accueil</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                Tableau de bord
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="dropdown-item text-danger">Déconnexion</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @else
                            <!-- Visiteur -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('choose.account') }}">Inscription</a>
                            </li>
                        @endauth
                    </ul>

                </div>
            </div>
        </nav>

        <!-- Recherche mobile -->
        <div class="d-lg-none mt-2">
            <form action="{{ route('properties.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control"
                           name="search"
                           placeholder="Rechercher un bien…"
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
