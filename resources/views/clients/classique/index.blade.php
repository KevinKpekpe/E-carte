@extends('clients.app')
@section('content')
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="bg-picture card-body">
                    <div class="d-flex align-items-top">
                        @if (auth()->user()->photo_profile)
                            <img src="{{ asset('storage/' . auth()->user()->photo_profile) }}"
                                class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3"
                                alt="profile-image">
                        @else
                            <img src="{{ asset('assets/images/default-profile.png') }}"
                                class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3"
                                alt="profile-image">
                        @endif

                        <div class="flex-grow-1 overflow-hidden">
                            <h4 class="m-0">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h4>
                            <p class="text-muted"><i>{{ auth()->user()->profession ?? 'Non spécifié' }}</i></p>
                            <p class="font-13">
                                <strong>Email:</strong> {{ auth()->user()->email }}<br>
                                <strong>Téléphone:</strong> {{ auth()->user()->telephone }}<br>
                                @if (auth()->user()->expiration_date)
                                    <strong>Date d'expiration:</strong>
                                    {{ \Carbon\Carbon::parse(auth()->user()->expiration_date)->format('d/m/Y') }}
                                @endif
                            </p>

                            <ul class="social-list list-inline mt-3 mb-0">
                                @foreach (auth()->user()->socialLinks as $socialLink)
                                    <li class="list-inline-item">
                                        <a href="{{ $socialLink->url }}" target="_blank"
                                            class="social-list-item border-purple text-purple">
                                            <i class="mdi mdi-facebook"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Informations personnelles</h4>
                    <form class="card-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" value="{{ Auth::user()->nom }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" value="{{ Auth::user()->prenom }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" value="{{ Auth::user()->telephone }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" class="form-control" id="profession"
                                value="{{ Auth::user()->profession ?? 'Non spécifié' }}" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">Supprimer mon compte</button>
                            </form>
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ auth()->user()->is_active ? 'Désactiver' : 'Activer' }} mon compte
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="header-title mt-0 mb-3">Actions sur le compte</h4>
                    <p class="text-muted">
                        Statut du compte:
                        <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ auth()->user()->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Changer mon mot de passe</h4>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('classique.update-password') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text">
                                Le mot de passe doit contenir au moins 8 caractères
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de
                                passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
