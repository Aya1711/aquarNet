<footer class="bg-dark text-white mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-home me-2"></i>Plateforme Immobilière
                </h5>
                <p class="text-light">Une plateforme complète réunissant agences et particuliers pour la vente et la location de biens dans un environnement sûr et fiable.</p>
                <div class="social-links mt-4">
                    <a href="#" class="text-white me-3" title="Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3" title="Twitter"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3" title="Instagram"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white" title="LinkedIn"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white text-decoration-none">Accueil</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}" class="text-white text-decoration-none">Biens</a></li>
                    <li class="mb-2"><a href="{{ route('agencies.index') }}" class="text-white text-decoration-none">Agences</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}" class="text-white text-decoration-none">Connexion</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Types de biens</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('properties.index', ['type' => 'appartement']) }}" class="text-white text-decoration-none">Appartements à vendre</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index', ['type' => 'maison']) }}" class="text-white text-decoration-none">Maisons à louer</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index', ['type' => 'villa']) }}" class="text-white text-decoration-none">Villas</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index', ['type' => 'terrain']) }}" class="text-white text-decoration-none">Terrains</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Contactez-nous</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i> 
                        <a href="tel:+212123456789" class="text-white text-decoration-none">+212 123 456 789</a>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i> 
                        <a href="mailto:info@realestate.ma" class="text-white text-decoration-none">info@realestate.ma</a>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> 
                        <span>Maroc</span>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock me-2"></i> 
                        <span>Dimanche - Jeudi: 9:00 - 18:00</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4 bg-light">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2024 Plateforme Immobilière. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white me-3 text-decoration-none">Politique de confidentialité</a>
                <a href="#" class="text-white me-3 text-decoration-none">Conditions d'utilisation</a>
                <a href="#" class="text-white text-decoration-none">Contactez-nous</a>
            </div>
        </div>
    </div>
</footer>
