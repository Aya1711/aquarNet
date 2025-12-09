@extends('layouts.app')

@section('title', 'Conditions d\'utilisation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="h3 mb-0"><i class="fas fa-file-contract me-2"></i>Conditions d'utilisation</h1>
                    <p class="mb-0 mt-2">Dernière mise à jour : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </div>
                
                <div class="card-body p-5">
                    <!-- Introduction -->
                    <section class="mb-5">
                        <h3 class="text-primary mb-3">Introduction</h3>
                        <p class="lead">
                            Bienvenue sur notre plateforme immobilière. Veuillez lire attentivement ces conditions avant d'utiliser le site.
                        </p>
                    </section>

                    <!-- Acceptation -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">1. Acceptation des conditions</h4>
                        <p>
                            En utilisant ce site, vous acceptez de respecter ces conditions générales. Si vous n'êtes pas d'accord avec ces conditions, veuillez ne pas utiliser le site.
                        </p>
                    </section>

                    <!-- Description du service -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">2. Description du service</h4>
                        <p>
                            Nous proposons une plateforme en ligne qui met en relation :
                        </p>
                        <ul>
                            <li>Les propriétaires souhaitant publier leurs biens à vendre ou à louer</li>
                            <li>Les agences immobilières enregistrées</li>
                            <li>Les particuliers à la recherche de biens à acheter ou à louer</li>
                        </ul>
                    </section>

                    <!-- Conditions d'inscription -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">3. Conditions d'inscription</h4>
                        <p>Pour créer un compte sur la plateforme, vous devez :</p>
                        <ul>
                            <li>Avoir 18 ans ou plus</li>
                            <li>Fournir des informations exactes et complètes</li>
                            <li>Maintenir la confidentialité de vos informations de compte</li>
                            <li>Assumer l'entière responsabilité de toutes les activités effectuées via votre compte</li>
                        </ul>
                    </section>

                    <!-- Responsabilités de l'utilisateur -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">4. Responsabilités de l'utilisateur</h4>
                        <p>En tant qu'utilisateur, vous vous engagez à ne pas :</p>
                        <ul>
                            <li>Publier des informations fausses ou trompeuses</li>
                            <li>Usurper l'identité d'autrui</li>
                            <li>Publier du contenu offensant ou illégal</li>
                            <li>Utiliser le site à des fins illégales</li>
                            <li>Tenter de pirater ou de perturber le système</li>
                        </ul>
                    </section>

                    <!-- Annonces immobilières -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">5. Conditions de publication des annonces</h4>
                        <p>Pour publier une annonce :</p>
                        <ul>
                            <li>Les informations fournies doivent être exactes et correctes</li>
                            <li>Les photos doivent être réelles et propres au bien publié</li>
                            <li>Déclarer tout défaut ou problème concernant le bien</li>
                            <li>Respecter les prix et conditions annoncés</li>
                        </ul>
                    </section>

                    <!-- Propriété intellectuelle -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">6. Propriété intellectuelle</h4>
                        <p>
                            Tout le contenu du site (textes, images, logos, etc.) est protégé par des droits de propriété intellectuelle et ne peut être copié ou distribué sans autorisation préalable.
                        </p>
                    </section>

                    <!-- Limitation de responsabilité -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">7. Limitation de responsabilité</h4>
                        <p>
                            Nous ne sommes pas responsables de :
                        </p>
                        <ul>
                            <li>La précision des informations fournies par les utilisateurs</li>
                            <li>Les résultats des transactions entre utilisateurs</li>
                            <li>Toute dommage résultant de l'utilisation du site</li>
                            <li>Tout dysfonctionnement technique hors de notre contrôle</li>
                        </ul>
                    </section>

                    <!-- Résiliation -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">8. Résiliation du service</h4>
                        <p>
                            Nous nous réservons le droit de suspendre ou de supprimer le compte de tout utilisateur enfreignant ces conditions sans préavis.
                        </p>
                    </section>

                    <!-- Modifications -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">9. Modifications des conditions</h4>
                        <p>
                            Nous nous réservons le droit de modifier ces conditions à tout moment et informerons les utilisateurs de tout changement substantiel.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section class="mb-5">
                        <h4 class="text-primary mb-3">10. Contact</h4>
                        <p>
                            Pour toute question concernant les conditions d'utilisation, veuillez nous contacter :
                            <br>
                            <i class="fas fa-envelope me-2"></i> contact@diar.com
                            <br>
                            <i class="fas fa-phone me-2"></i> +212 5 00 00 00 00
                        </p>
                    </section>

                    <div class="text-center mt-5">
                        <a href="{{ route('register') }}" class="btn btn-primary me-3">
                            <i class="fas fa-user-plus me-2"></i>Créer un compte
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
