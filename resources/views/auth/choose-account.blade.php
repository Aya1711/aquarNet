@extends('layouts.app')

@section('title', 'Choisissez le type de compte - Plateforme Immobilière')

@section('content')
<div class="account-selection-page">
    <!-- En-tête principal -->
    <div class="text-center mb-12">
        <h1 class="main-title">
            Choisissez le type de compte
        </h1>
        <p class="main-subtitle">
            Sélectionnez le type de compte qui correspond à vos besoins
        </p>
    </div>

    <!-- Cartes de sélection -->
    <div class="account-cards-container">
        <!-- Carte utilisateur individuel -->
        <div class="account-card">
            <div class="card-content">
                <!-- En-tête de la carte -->
                <div class="card-header">
                    <div class="icon-circle user-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="card-title">Utilisateur individuel</h3>
                    <p class="card-subtitle">Propriétaire ou chercheur de bien immobilier</p>
                </div>

                <!-- Fonctionnalités -->
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Publier vos annonces immobilières</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Modifier ou supprimer vos annonces</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Ajouter des photos et une description détaillée</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Gérer vos biens à vendre ou à louer</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Consulter les offres disponibles</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Envoyer des messages aux agences ou propriétaires</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Enregistrer vos annonces favorites</span>
                    </div>
                </div>

                <!-- Bouton -->
                <a href="{{ route('register') }}" 
                   class="account-btn user-btn">
                    Créer un compte
                </a>
            </div>
        </div>

        <!-- Carte agence -->
        <div class="account-card">
            <div class="card-content">
                <!-- En-tête de la carte -->
                <div class="card-header">
                    <div class="icon-circle agency-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="card-title">Compte agence</h3>
                    <p class="card-subtitle">Spécialiste immobilier</p>
                </div>

                <!-- Fonctionnalités -->
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Publier un nombre illimité d'annonces</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Gérer plusieurs biens immobiliers</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Ajouter des descriptions professionnelles et des photos de haute qualité</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Gérer les demandes de réservation ou d'achat</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Accéder aux statistiques de performance des annonces</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Communiquer avec les clients via le système de messagerie</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-check"></i>
                        <span class="feature-text">Organiser les visites et rendez-vous</span>
                    </div>
                </div>

                <!-- Bouton -->
                <a href="{{ route('register.agency.form') }}" 
                   class="account-btn agency-btn">
                    Créer un compte
                </a>
            </div>
        </div>
    </div>

    <!-- Section d'information -->
    <div class="info-section">
        <h2 class="info-title">
            Rejoignez notre plateforme et commencez dès maintenant !
        </h2>
        <p class="info-text">
            Des milliers de propriétaires et d'agences nous font confiance pour leurs transactions immobilières.
        </p>
        <div class="stats-container">
            <div class="stat-item">
                <i class="fas fa-home stat-icon"></i>
                <span class="stat-text">+5000 biens</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-users stat-icon"></i>
                <span class="stat-text">+1000 agences</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-shield-alt stat-icon"></i>
                <span class="stat-text">100% sécurisé</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rendre les cartes cliquables entièrement
    const accountCards = document.querySelectorAll('.account-card');
    
    accountCards.forEach(card => {
        const link = card.querySelector('.account-btn');
        
        card.addEventListener('click', function(e) {
            if (e.target.tagName !== 'A' && !e.target.closest('.account-btn')) {
                link.click();
            }
        });
        
        // Ajouter des effets hover supplémentaires
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.cursor = 'default';
        });
    });
    
    // Effets d'animation à l'entrée de la page
    const cardsToAnimate = document.querySelectorAll('.account-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, { threshold: 0.1 });
    
    cardsToAnimate.forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });
});
</script>
@endsection
