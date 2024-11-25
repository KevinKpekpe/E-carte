@extends('clients.app')
@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="bg-picture card-body">
                <div class="d-flex align-items-top">
                    @if(auth()->user()->photo_profile)
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
                            @if(auth()->user()->expiration_date)
                                <strong>Date d'expiration:</strong> {{ \Carbon\Carbon::parse(auth()->user()->expiration_date)->format('d/m/Y') }}
                            @endif
                        </p>

                        <ul class="social-list list-inline mt-3 mb-0">
                            @foreach(auth()->user()->socialLinks as $socialLink)
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
    </div>

    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('classique.password')}}" class="dropdown-item">Changer de mot de passe</a>
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
    </div>
</div>
@endsection
