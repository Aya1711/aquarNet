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
<style>
    /* ========== ROOT VARIABLES ========== */
:root {
    --orange: #FF6B35;
    --light-orange: #FF8C5A;
    --dark-orange: #E55A2B;
    --gray: #6C757D;
    --dark-gray: #495057;
    --light-gray: #E9ECEF;
    --beige: #F8F9FA;
    --dark-beige: #E8E8E0;
    --white: #FFFFFF;
}

/* ========== MAIN CONTAINER ========== */

.account-selection-page {
    min-height: 100vh;
    padding: 3rem 1rem;
    direction: rtl;
    position: relative;

    /* IMAGE DE FOND */
    background-image: url('/images/bg4.png'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    /* overlay pour assombrir légèrement l'image et améliorer lisibilité */
    /* background-color: rgba(0, 0, 0, 0.3);  */
    background-blend-mode: overlay;
}


/* ========== HEADER SECTION ========== */
.text-center.mb-12 {
    margin-bottom: 3rem;
}

.main-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark-gray);
    margin-bottom: 1rem;
    line-height: 1.2;
    position: relative;
}

.main-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    right: 50%;
    transform: translateX(50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, var(--orange), var(--light-orange));
    border-radius: 2px;
}

.main-subtitle {
    font-size: 1.25rem;
    color: var(--gray);
    margin-bottom: 0;
    margin-top: 2rem;
}

/* ========== ACCOUNT CARDS CONTAINER ========== */
.account-cards-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto 4rem;
}

@media (min-width: 768px) {
    .account-cards-container {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
}

/* ========== ACCOUNT CARD ========== */
.account-card {
    background: rgba(255, 255, 255, 0.15); /* fond semi-transparent */
    backdrop-filter: blur(10px); /* flou derrière pour effet glass */
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2); /* ombre pour détacher la carte */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid rgba(255,255,255,0.2); /* bord léger pour délimiter la carte */
    overflow: hidden;
    position: relative;
    color: #fff; /* texte blanc pour contraster avec le fond */
}


.account-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(255, 107, 53, 0.15);
    border-color: var(--orange);
}

.account-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, var(--orange), var(--light-orange));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.account-card:hover::before {
    transform: scaleX(1);
}

.card-content {
    padding: 2.5rem;
}

/* ========== CARD HEADER ========== */
.card-header {
    text-align: center;
    margin-bottom: 2rem;
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    transition: all 0.4s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.user-icon {
    background: linear-gradient(135deg, var(--orange), var(--light-orange));
    color: var(--white);
}

.agency-icon {
    background: linear-gradient(135deg, var(--gray), var(--dark-gray));
    color: var(--white);
}

.icon-circle i {
    font-size: 2rem;
    transition: all 0.4s ease;
}

.account-card:hover .icon-circle {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
}

.account-card:hover .icon-circle i {
    transform: rotate(5deg);
}

.card-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-gray);
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.account-card:hover .card-title {
    color: var(--orange);
}

.card-subtitle {
    color: var(--gray);
    font-size: 1.1rem;
    margin-bottom: 0;
}

/* ========== FEATURES LIST ========== */
.features-list {
    margin-bottom: 2.5rem;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    background: var(--dark-beige);
}

.feature-item:hover {
    background: rgba(255, 107, 53, 0.05);
    transform: translateX(-5px);
}

.feature-check {
    color: var(--orange);
    margin-left: 1rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.feature-text {
    color: var(--dark-gray);
    line-height: 1.5;
    flex: 1;
    font-weight: 500;
}

/* ========== BUTTONS ========== */
.account-btn {
    display: block;
    width: 100%;
    padding: 1rem 2rem;
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1.1rem;
    text-align: center;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.account-btn::before {
    content: '';
    position: absolute;
    top: 0;
    right: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: right 0.6s ease;
}

.account-btn:hover::before {
    right: 100%;
}

.user-btn {
    background: linear-gradient(135deg, var(--orange), var(--light-orange));
    color: var(--white);
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.user-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    background: linear-gradient(135deg, var(--light-orange), var(--orange));
    color: var(--white);
}

.agency-btn {
    background: linear-gradient(135deg, var(--gray), var(--dark-gray));
    color: var(--white);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.agency-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
    background: linear-gradient(135deg, var(--dark-gray), var(--gray));
    color: var(--white);
}

/* ========== INFO SECTION ========== */
.info-section {
    background: linear-gradient(135deg, rgba(255, 107, 53, 0.05), rgba(108, 117, 125, 0.7));
    border-radius: 1.5rem;
    padding: 3rem 2rem;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid rgba(255, 107, 53, 0.1);
    position: relative;
    overflow: hidden;
}

.info-section::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, var(--orange), var(--light-orange));
}

.info-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-gray);
    margin-bottom: 1rem;
}

.info-text {
    font-size: 1.1rem;
    color: var(--gray);
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* ========== STATS CONTAINER ========== */
.stats-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    justify-content: center;
    align-items: center;
}

@media (min-width: 640px) {
    .stats-container {
        flex-direction: row;
        gap: 3rem;
    }
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-icon {
    color: var(--orange);
    font-size: 1.5rem;
}

.stat-text {
    color: var(--dark-gray);
    font-weight: 600;
    font-size: 1.1rem;
}

/* ========== ANIMATIONS ========== */
.account-card {
    animation: fadeInUp 0.8s ease-out;
}

.account-card:nth-child(2) {
    animation-delay: 0.2s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ========== RESPONSIVE DESIGN ========== */
@media (max-width: 768px) {
    .account-selection-page {
        padding: 2rem 1rem;
    }
    
    .main-title {
        font-size: 2rem;
    }
    
    .main-subtitle {
        font-size: 1.1rem;
    }
    
    .card-content {
        padding: 2rem 1.5rem;
    }
    
    .info-section {
        padding: 2rem 1.5rem;
    }
    
    .info-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .main-title {
        font-size: 1.75rem;
    }
    
    .card-content {
        padding: 1.5rem 1rem;
    }
    
    .icon-circle {
        width: 70px;
        height: 70px;
    }
    
    .icon-circle i {
        font-size: 1.75rem;
    }
    
    .card-title {
        font-size: 1.5rem;
    }
    
    .account-btn {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}
</style>