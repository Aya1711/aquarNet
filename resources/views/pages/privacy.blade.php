@extends('layouts.app')

@section('title', 'Politique de confidentialité')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <h1 class="h3 mb-0"><i class="fas fa-shield-alt me-2"></i>Politique de confidentialité</h1>
                    <p class="mb-0 mt-2">La protection de vos données est notre priorité</p>
                </div>
                
                <div class="card-body p-5">
                    <!-- Introduction -->
                    <section class="mb-5">
                        <h3 class="text-success mb-3">Introduction</h3>
                        <p class="lead">
                            Nous nous engageons à protéger votre vie privée et vos données personnelles. Cette politique explique comment nous collectons, utilisons et protégeons vos informations.
                        </p>
                    </section>

                    <!-- Informations collectées -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">1. Informations collectées</h4>
                        <p>Nous collectons les types d’informations suivants :</p>
                        
                        <h5 class="text-success mt-4">a. Informations personnelles</h5>
                        <ul>
                            <li>Nom complet</li>
                            <li>Adresse e-mail</li>
                            <li>Numéro de téléphone</li>
                            <li>Adresse (optionnelle)</li>
                        </ul>

                        <h5 class="text-success mt-4">b. Informations sur les biens</h5>
                        <ul>
                            <li>Photos des biens</li>
                            <li>Caractéristiques des biens</li>
                            <li>Localisation et adresse</li>
                            <li>Prix et conditions</li>
                        </ul>

                        <h5 class="text-success mt-4">c. Informations de navigation</h5>
                        <ul>
                            <li>Adresse IP</li>
                            <li>Type de navigateur</li>
                            <li>Pages consultées</li>
                            <li>Heure et durée des visites</li>
                        </ul>
                    </section>

                    <!-- Utilisation des informations -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">2. Utilisation des informations</h4>
                        <p>Nous utilisons vos informations pour :</p>
                        <ul>
                            <li>Fournir et améliorer nos services</li>
                            <li>Faciliter la communication entre utilisateurs</li>
                            <li>Envoyer des notifications importantes</li>
                            <li>Analyser et optimiser l’utilisation du site</li>
                            <li>Prévenir la fraude et protéger contre les activités illégales</li>
                        </ul>
                    </section>

                    <!-- Partage des informations -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">3. Partage des informations</h4>
                        <p>Nous ne vendons ni ne louons vos informations personnelles à des tiers. Nous pouvons partager les informations uniquement dans les cas suivants :</p>
                        <ul>
                            <li>Avec des prestataires de services nous aidant à gérer le site</li>
                            <li>Lorsque requis par la loi</li>
                            <li>Pour protéger nos droits et nos biens</li>
                            <li>Avec votre consentement explicite</li>
                        </ul>
                    </section>

                    <!-- Sécurité des informations -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">4. Sécurité des informations</h4>
                        <p>Nous utilisons plusieurs mesures de sécurité pour protéger vos informations :</p>
                        <ul>
                            <li>Cryptage des données</li>
                            <li>Pare-feu</li>
                            <li>Surveillance continue des systèmes</li>
                            <li>Accès restreint aux employés</li>
                        </ul>
                    </section>

                    <!-- Cookies -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">5. Cookies</h4>
                        <p>
                            Nous utilisons des cookies pour améliorer l’expérience utilisateur. Vous pouvez configurer votre navigateur pour refuser les cookies, mais cela peut affecter certaines fonctionnalités du site.
                        </p>
                    </section>

                    <!-- Droits des utilisateurs -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">6. Droits des utilisateurs</h4>
                        <p>Vous avez le droit de :</p>
                        <ul>
                            <li>Accéder à vos informations personnelles</li>
                            <li>Corriger les informations inexactes</li>
                            <li>Demander la suppression de vos données</li>
                            <li>S’opposer au traitement de vos données</li>
                            <li>Demander le transfert de vos données</li>
                        </ul>
                    </section>

                    <!-- Conservation des données -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">7. Durée de conservation des données</h4>
                        <p>
                            Nous conservons vos données tant que votre compte est actif ou selon les obligations légales. Vous pouvez demander la suppression de votre compte à tout moment.
                        </p>
                    </section>

                    <!-- Modifications de la politique -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">8. Modifications de la politique</h4>
                        <p>
                            Nous pouvons mettre à jour cette politique périodiquement. Nous vous informerons de tout changement substantiel.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section class="mb-5">
                        <h4 class="text-success mb-3">9. Contact</h4>
                        <p>
                            Pour toute question concernant la politique de confidentialité ou pour exercer vos droits, veuillez nous contacter :
                            <br>
                            <i class="fas fa-envelope me-2"></i> privacy@diar.com
                            <br>
                            <i class="fas fa-phone me-2"></i> +212 5 00 00 00 00
                        </p>
                    </section>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Remarque :</strong> En utilisant ce site, vous acceptez cette politique de confidentialité.
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('register') }}" class="btn btn-success me-3">
                            <i class="fas fa-user-plus me-2"></i>Créer un compte
                        </a>
                        <a href="{{ route('terms') }}" class="btn btn-outline-success me-3">
                            <i class="fas fa-file-contract me-2"></i>Conditions d'utilisation
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
