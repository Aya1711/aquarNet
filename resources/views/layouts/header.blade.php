<header class="bg-white shadow-sm sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <!-- الشعار -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-home me-2"></i>
                    {{ __('platform_name') }}
                </a>


                <!-- زر القائمة على الجوال -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- محتويات القائمة -->
                <div class="collapse navbar-collapse" id="navbarMain">
                    <!-- القائمة الرئيسية -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>{{ __('home_nav') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('properties') || request()->is('properties/*') ? 'active' : '' }}"
                               href="{{ route('properties.index') }}">
                                <i class="fas fa-building me-1"></i>{{ __('properties_nav') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('agencies') || request()->is('agencies/*') ? 'active' : '' }}"
                               href="{{ route('agencies.index') }}">
                                <i class="fas fa-city me-1"></i>{{ __('agencies_nav') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-plus-circle me-1"></i>{{ __('add_property_nav') }}
                            </a>
                            <ul class="dropdown-menu">
                                @auth
                                    <li>
                                        <a class="dropdown-item" href="{{ route('properties.create') }}">
                                            <i class="fas fa-home me-2"></i>{{ __('add_property') }}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt me-2"></i>{{ __('login') }}
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </li>
                    </ul>

                    <!-- عناصر المستخدم -->
                    <ul class="navbar-nav">
                        @auth
                            {{-- ✅ إخفاء العناصر للمشرف --}}
                            @if(Auth::user()->role !== 'admin')
                                <!-- الإشعارات -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-bell"></i>
                                        @if(auth()->user()->messagesRecus()->unread()->count() > 0)
                                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">
                                            {{ auth()->user()->messagesRecus()->unread()->count() }}
                                        </span>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><h6 class="dropdown-header">{{ __('notifications') }}</h6></li>
                                        @forelse(auth()->user()->messagesRecus()->unread()->take(5)->get() as $message)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('users.messages.index') }}">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <small>{{ Str::limit($message->contenu, 30) }}</small>
                                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        </li>
                                        @empty
                                        <li><a class="dropdown-item text-muted" href="#">{{ __('no_new_notifications') }}</a></li>
                                        @endforelse
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-center" href="{{ route('users.messages.index') }}">{{ __('view_all') }}</a></li>
                                    </ul>
                                </li>

                                <!-- المفضلة -->
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

                                <!-- حساب المستخدم -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="{{ route('user.profile') }}" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user me-1"></i>
                                        {{ Auth::user()->name }}
                                        <span class="badge bg-{{ Auth::user()->role == 'agence' ? 'success' : 'primary' }} ms-1" style="font-size: 0.6em;">
                                            {{ Auth::user()->role == 'agence' ? __('agency') : __('individual') }}
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                                <i class="fas fa-user me-2"></i>{{ __('profile') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.properties') }}">
                                                <i class="fas fa-home me-2"></i>{{ __('my_properties') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('logout') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>

                            @else
                                {{-- ✅ في حالة الـ Admin --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-shield me-1"></i>
                                        {{ Auth::user()->name }} ({{ __('admin') }})
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                         {{-- الرجوع إلى الرئيسية --}}
                                        <li>
                                            <a class="dropdown-item text-primary" href="{{ url('/') }}">
                                                <i class="fas fa-home me-2"></i>{{ __('home') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <a class="dropdown-item text-warning" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-cog me-2"></i>{{ __('dashboard') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('logout') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                        @else
                            <!-- زوار غير مسجلين -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>{{ __('login') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('choose.account') }}">
                                    <i class="fas fa-user-plus me-1"></i>{{ __('register') }}
                                </a>
                            </li>
                        @endauth
                    </ul>

                </div>
            </div>
        </nav>

        <!-- شريط البحث للجوال -->
        <div class="d-lg-none mt-2">
            <form action="{{ route('properties.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('search_placeholder') }}"
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- شريط التقدم للتحميل -->
    <div class="progress-container" style="height: 3px; background: #f0f0f0; display: none;">
        <div class="progress-bar" style="height: 3px; background: #3498db; width: 0%; transition: width 0.3s;"></div>
    </div>
</header>

<!-- الرسائل العابرة -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-0 rounded-0" role="alert">
    <div class="container">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
    <div class="container">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
    <div class="container">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>{{ __('error_occurred') }}</strong> {{ __('review_data') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
