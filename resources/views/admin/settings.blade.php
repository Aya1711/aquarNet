@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>Paramètres du système
                    </h4>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Nom du site</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" value="Plateforme Immobilière">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="site_email" name="site_email" value="info@realestate.ma">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="+212 123 456 789">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Devise</label>
                                    <select class="form-control" id="currency" name="currency">
                                        <option value="MAD" selected>Dirham marocain (MAD)</option>
                                        <option value="EUR">Euro (EUR)</option>
                                        <option value="USD">Dollar américain (USD)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description du site</label>
                            <textarea class="form-control" id="description" name="description" rows="3">Une plateforme complète réunissant agences immobilières et particuliers pour la vente et la location de logements dans un environnement sûr et fiable.</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode">
                                <label class="form-check-label" for="maintenance_mode">
                                    Mode maintenance
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les paramètres
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
