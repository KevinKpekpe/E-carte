@extends('admin.app')
@section('title','Liste des utilisateurs')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="mt-3 mt-md-0">
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                        class="mdi mdi-plus-circle me-1"></i> Ajouter un
                                    user</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form class="d-flex flex-wrap align-items-center justify-content-sm-end" method="GET"
                                action="{{ route('admin.users.index') }}">
                                <label for="status-select" class="me-2">Trier par</label>
                                <div class="me-sm-2">
                                    <select class="form-select my-1 my-md-0" id="status-select" name="sort"
                                        onchange="this.form.submit()">
                                        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>All</option>
                                        <option value="1" {{ request('sort') == '1' ? 'selected' : '' }}>Nom</option>
                                        <option value="2" {{ request('sort') == '2' ? 'selected' : '' }}>Type</option>
                                        <option value="3" {{ request('sort') == '3' ? 'selected' : '' }}>Statut
                                        </option>
                                    </select>
                                </div>
                                <label for="search" class="visually-hidden">Search</label>
                                <div class="d-flex">
                                    <input type="search" class="form-control my-1 my-md-0" id="search" name="search"
                                        placeholder="Search..." value="{{ request('search') }}">
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
                            <th scope="col">Nom complet</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Type</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->nom }} {{ $user->prenom }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->userType->name }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                            <a href="javascript:void(0);" class="dropdown-item"
                                                onclick="showEditModal({{ $user->id }}, {{ json_encode($user) }})">Modifier</a>
                                        </div>
                                    </div>

                                    @if ($user->is_active)
                                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm mt-2">
                                                Bloquer cet utilisateur
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.send-activation', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm mt-2">
                                                Envoyer lien d'activation
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Aucun utilisateur trouvé</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="modal-title">Ajouter un membre</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="method-field"></div>

                        <!-- Type d'utilisateur -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="user_type_id" class="form-label">Type d'utilisateur</label>
                                <select class="form-select @error('user_type_id') is-invalid @enderror" id="user_type_id"
                                    name="user_type_id" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="2">Classique</option>
                                    <option value="3">Premium</option>
                                    <option value="4">Entreprise</option>
                                </select>
                                @error('user_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Première rangée -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nom" class="form-label">Nom</label>
                                <input class="form-control @error('nom') is-invalid @enderror" type="text"
                                    id="nom" name="nom" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input class="form-control @error('prenom') is-invalid @enderror" type="text"
                                    id="prenom" name="prenom" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="email" class="form-label">Adresse email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champs entreprise -->
                        <div id="enterprise-fields" class="row mb-3" style="display: none;">
                            <div class="col-md-6">
                                <label for="nom_entreprise" class="form-label">Nom de l'entreprise</label>
                                <input class="form-control @error('nom_entreprise') is-invalid @enderror" type="text"
                                    id="nom_entreprise" name="nom_entreprise">
                                @error('nom_entreprise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_employes" class="form-label">Nombre d'employés</label>
                                <input class="form-control @error('nombre_employes') is-invalid @enderror" type="number"
                                    id="nombre_employes" name="nombre_employes">
                                @error('nombre_employes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deuxième rangée -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input class="form-control @error('telephone') is-invalid @enderror" type="text"
                                    id="telephone" name="telephone" required>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="profession" class="form-label">Profession</label>
                                <input class="form-control @error('profession') is-invalid @enderror" type="text"
                                    id="profession" name="profession" required>
                                @error('profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="photo" class="form-label">Photo de profil</label>
                                <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                    id="photo" name="photo">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Fields (only for creation) -->
                        <div id="password-fields" class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>

                        <!-- Section Réseaux Sociaux -->
                        <div class="mb-3">
                            <label class="form-label">Réseaux Sociaux</label>
                            <div id="social-links">
                                <div class="social-link-item mb-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="social_links[0][platform]"
                                                placeholder="Plateforme">
                                        </div>
                                        <div class="col-md-8">
                                            <input type="url" class="form-control" name="social_links[0][url]"
                                                placeholder="URL">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-social-link">
                                Ajouter un réseau social
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light"
                            data-bs-dismiss="modal">Retour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let socialLinkCount = 1;

        document.getElementById('add-social-link').addEventListener('click', function() {
            const socialLinksDiv = document.getElementById('social-links');
            const newSocialLink = `
        <div class="social-link-item mb-2">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="social_links[${socialLinkCount}][platform]" placeholder="Plateforme">
                </div>
                <div class="col-md-8">
                    <input type="url" class="form-control" name="social_links[${socialLinkCount}][url]" placeholder="URL">
                </div>
            </div>
        </div>
    `;
            socialLinksDiv.insertAdjacentHTML('beforeend', newSocialLink);
            socialLinkCount++;
        });

        document.getElementById('user_type_id').addEventListener('change', function() {
            const enterpriseFields = document.getElementById('enterprise-fields');
            const nomEntreprise = document.getElementById('nom_entreprise');
            const nombreEmployes = document.getElementById('nombre_employes');

            if (this.value === '4') {
                enterpriseFields.style.display = 'flex';
                nomEntreprise.required = true;
                nombreEmployes.required = true;
            } else {
                enterpriseFields.style.display = 'none';
                nomEntreprise.required = false;
                nombreEmployes.required = false;
            }
        });

        // Fonction pour remplir le modal pour l'édition
        function editUser(user) {
            const form = document.getElementById('userForm');
            const modalTitle = document.getElementById('modal-title');
            const methodField = document.getElementById('method-field');

            modalTitle.textContent = 'Modifier un membre';
            form.action = `/users/${user.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

            // Remplir les champs
            document.getElementById('user_type_id').value = user.user_type_id;
            document.getElementById('nom').value = user.nom;
            document.getElementById('prenom').value = user.prenom;
            document.getElementById('email').value = user.email;
            document.getElementById('telephone').value = user.telephone;
            document.getElementById('profession').value = user.profession;

            // Gérer les champs d'entreprise
            if (user.company) {
                document.getElementById('nom_entreprise').value = user.company.nom_entreprise;
                document.getElementById('nombre_employes').value = user.company.nombre_employes;
                document.getElementById('enterprise-fields').style.display = 'flex';
            }

            // Cacher les champs de mot de passe pour l'édition
            document.getElementById('password-fields').style.display = 'none';

            // Remplir les réseaux sociaux
            const socialLinksDiv = document.getElementById('social-links');
            socialLinksDiv.innerHTML = '';
            if (user.social_links) {
                user.social_links.forEach((link, index) => {
                    const socialLinkHtml = `
                <div class="social-link-item mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="social_links[${index}][platform]"
                                value="${link.platform}" placeholder="Plateforme">
                        </div>
                        <div class="col-md-8">
                            <input type="url" class="form-control" name="social_links[${index}][url]"
                                value="${link.url}" placeholder="URL">
                        </div>
                    </div>
                </div>
            `;
                    socialLinksDiv.insertAdjacentHTML('beforeend', socialLinkHtml);
                });
                socialLinkCount = user.social_links.length;
            }
        }

        // Fonction pour réinitialiser le modal pour la création
        function resetModal() {
            const form = document.getElementById('userForm');
            const modalTitle = document.getElementById('modal-title');
            const methodField = document.getElementById('method-field');

            modalTitle.textContent = 'Ajouter un membre';
            form.action = '/users';
            methodField.innerHTML = '';
            form.reset();

            document.getElementById('enterprise-fields').style.display = 'none';
            document.getElementById('password-fields').style.display = 'block';

            const socialLinksDiv = document.getElementById('social-links');
            socialLinksDiv.innerHTML = `
        <div class="social-link-item mb-2">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="social_links[0][platform]" placeholder="Plateforme">
                </div>
                <div class="col-md-8">
                    <input type="url" class="form-control" name="social_links[0][url]" placeholder="URL">
                </div>
            </div>
        </div>
    `;
            socialLinkCount = 1;
        }
        document.addEventListener('DOMContentLoaded', function() {
            let searchTimeout;
            const searchInput = document.getElementById('search');
            const form = searchInput.closest('form');

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    form.submit();
                }, 500);
            });
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    form.submit();
                }
            });
        });
        // Pour créer un nouvel utilisateur
        function showCreateModal() {
            resetModal();
            $('#custom-modal').modal('show');
        }

 function showEditModal(userId, userData) {
    // Réinitialiser le formulaire
    resetModal();

    // Mettre à jour le titre et l'action du formulaire
    document.getElementById('modal-title').textContent = 'Modifier un membre';
    const form = document.getElementById('userForm');
    form.action = `/admin/users/${userId}`;
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';

    // Remplir les champs avec les données de l'utilisateur
    document.getElementById('user_type_id').value = userData.user_type_id;
    document.getElementById('nom').value = userData.nom;
    document.getElementById('prenom').value = userData.prenom;
    document.getElementById('email').value = userData.email;
    document.getElementById('telephone').value = userData.telephone;
    document.getElementById('profession').value = userData.profession;

    // Gérer les champs d'entreprise si nécessaire
    if (userData.company) {
        document.getElementById('enterprise-fields').style.display = 'flex';
        document.getElementById('nom_entreprise').value = userData.company.nom_entreprise;
        document.getElementById('nombre_employes').value = userData.company.nombre_employes;
    }

    // Masquer les champs de mot de passe pour l'édition
    document.getElementById('password-fields').style.display = 'none';

    // Remplir les réseaux sociaux
    const socialLinksDiv = document.getElementById('social-links');
    socialLinksDiv.innerHTML = '';
    if (userData.social_links && userData.social_links.length > 0) {
        userData.social_links.forEach((link, index) => {
            const socialLinkHtml = `
                <div class="social-link-item mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="social_links[${index}][platform]"
                                value="${link.platform}" placeholder="Plateforme">
                        </div>
                        <div class="col-md-8">
                            <input type="url" class="form-control" name="social_links[${index}][url]"
                                value="${link.url}" placeholder="URL">
                        </div>
                    </div>
                </div>
            `;
            socialLinksDiv.insertAdjacentHTML('beforeend', socialLinkHtml);
        });
        socialLinkCount = userData.social_links.length;
    }

    // Afficher le modal
    const modal = new bootstrap.Modal(document.getElementById('custom-modal'));
    modal.show();
}

    </script>
@endsection
