@extends('auth.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">Création de compte Entreprise</h4>
                        </div>

                        <form action="{{route('register.entreprise')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Informations personnelles -->
                            <h5 class="mb-3">Informations personnelles</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input class="form-control @error('nom') is-invalid @enderror" type="text"
                                        id="nom" name="nom" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input class="form-control @error('prenom') is-invalid @enderror" type="text"
                                        id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Adresse email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations de l'entreprise -->
                            <h5 class="mb-3">Informations de l'entreprise</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom_entreprise" class="form-label">Nom de l'entreprise</label>
                                    <input class="form-control @error('nom_entreprise') is-invalid @enderror" type="text"
                                        id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}" required>
                                    @error('nom_entreprise')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre_employes" class="form-label">Nombre d'employés</label>
                                    <input class="form-control @error('nombre_employes') is-invalid @enderror" type="number"
                                        id="nombre_employes" name="nombre_employes" value="{{ old('nombre_employes') }}" required>
                                    @error('nombre_employes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Autres informations -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input class="form-control @error('telephone') is-invalid @enderror" type="text"
                                        id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="profession" class="form-label">Profession</label>
                                    <input class="form-control @error('profession') is-invalid @enderror" type="text"
                                        id="profession" name="profession" value="{{ old('profession') }}" required>
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

                            <!-- Mot de passe -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                    <input class="form-control" type="password" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <!-- Réseaux Sociaux -->
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

                            <!-- Terms -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        J'accepte les <a href="javascript: void(0);" class="text-dark">termes & conditions</a>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 text-center">
                                <button class="btn btn-primary px-4" type="submit">Créer le compte</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-dark ms-1"><b>Connexion</b></a>
                        </p>
                    </div>
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
                            <input type="text"
                                class="form-control"
                                name="social_links[${socialLinkCount}][platform]"
                                placeholder="Plateforme">
                        </div>
                        <div class="col-md-8">
                            <input type="url"
                                class="form-control"
                                name="social_links[${socialLinkCount}][url]"
                                placeholder="URL">
                        </div>
                    </div>
                </div>
            `;
            socialLinksDiv.insertAdjacentHTML('beforeend', newSocialLink);
            socialLinkCount++;
        });
    </script>
@endsection
