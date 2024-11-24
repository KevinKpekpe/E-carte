@extends('clients.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="mt-3 mt-md-0">
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#custom-modal">
                                    <i class="mdi mdi-plus-circle me-1"></i> Ajouter un employé
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form class="d-flex flex-wrap align-items-center justify-content-sm-end" method="GET"
                                action="">
                                <label for="status-select" class="me-2">Trier par</label>
                                <div class="me-sm-2">
                                    <select class="form-select my-1 my-md-0" id="status-select">
                                        <option value="">All</option>
                                        <option value="1">Nom</option>
                                        <option value="2">Type</option>
                                        <option value="3">Statut
                                        </option>
                                    </select>
                                </div>
                                <label for="search" class="visually-hidden">Search</label>
                                <div class="d-flex">
                                    <input type="search" class="form-control my-1 my-md-0" id="search" name="search"
                                        placeholder="Search..." value="">
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Profession</th>
                            <th>Date d'expiration</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>john.doe@example.com</td>
                            <td>+1 234 567 890</td>
                            <td>Développeur</td>
                            <td>2024-12-31</td>
                            <td>
                                <span class="badge bg-success">Actif</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Modifier</button>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>jane.smith@example.com</td>
                            <td>+1 234 567 891</td>
                            <td>Designer</td>
                            <td>2024-11-30</td>
                            <td>
                                <span class="badge bg-danger">Inactif</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Modifier</button>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Robert Johnson</td>
                            <td>robert.j@example.com</td>
                            <td>+1 234 567 892</td>
                            <td>Marketing Manager</td>
                            <td>2024-10-15</td>
                            <td>
                                <span class="badge bg-success">Actif</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Modifier</button>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ajout/Modification -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title">Ajouter un employé</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Première rangée -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nom" class="form-label">Nom</label>
                                <input class="form-control" type="text" id="nom" name="nom" required>
                            </div>
                            <div class="col-md-4">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input class="form-control" type="text" id="prenom" name="prenom" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Deuxième rangée -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input class="form-control" type="text" id="telephone" name="telephone" required>
                            </div>
                            <div class="col-md-4">
                                <label for="profession" class="form-label">Profession</label>
                                <input class="form-control" type="text" id="profession" name="profession" required>
                            </div>
                            <div class="col-md-4">
                                <label for="photo_profile" class="form-label">Photo de profil</label>
                                <input class="form-control" type="file" id="photo_profile" name="photo_profile">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
