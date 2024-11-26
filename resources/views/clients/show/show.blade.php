@extends('clients.base')

@section('title', $user->nom . ' ' . $user->prenom)

@section('meta')
    <meta property="og:title" content="{{ $user->nom }} {{ $user->prenom }} - {{ $user->profession }}">
    <meta property="og:description" content="Carte de visite digitale de {{ $user->nom }} {{ $user->prenom }}">
    @if($user->photo_profile)
        <meta property="og:image" content="{{ asset('storage/' . $user->photo_profile) }}">
    @endif
@endsection

@section('styles')
<style>
    /* Styles personnalisés pour les icônes de réseaux sociaux */
    .social-icon {
        margin: 0 10px;
        font-size: 24px;
        transition: all 0.3s ease;
    }
    .social-icon:hover { transform: scale(1.2); }
    .social-icon.linkedin { color: #0077b5; }
    .social-icon.facebook { color: #3b5998; }
    .social-icon.twitter { color: #1da1f2; }
    .social-icon.whatsapp { color: #25d366; }
    .social-icon.snapchat { color: #fffc00; }
    .social-icon.instagram { color: #e4405f; }
    .social-icon.youtube { color: #ff0000; }
    .social-icon.github { color: #333; }

    /* Styles pour les boutons d'action */
    .btn-custom {
        margin: 10px;
        padding: 10px 20px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-custom a {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
    <div class="header__wrapper">
        <header></header>
        <div class="cols__container">
            <div class="left__col">
                <!-- Section Photo de profil -->
                <div class="img__container">
                    @if($user->photo_profile)
                        <img src="{{ asset('storage/' . $user->photo_profile) }}"
                             alt="{{ $user->nom }} {{ $user->prenom }}"
                             onerror="this.src='{{ asset('images/default-profile.jpg') }}'" />
                    @else
                        <img src="{{ asset('images/default-profile.jpg') }}"
                             alt="{{ $user->nom }} {{ $user->prenom }}" />
                    @endif
                    <span></span>
                </div>

                <!-- Informations principales -->
                <h2>{{ $user->nom }} {{ $user->prenom }}</h2>
                <p class="profession">{{ $user->profession }}</p>

                <!-- Coordonnées -->
                @if($user->telephone)
                    <ul class="about">
                        <li><span>Numéro de téléphone :</span></li>
                        <li>{{ $user->telephone }}</li>
                    </ul>
                @endif

                @if($user->email)
                    <ul class="about">
                        <li><span>E-mail :</span></li>
                        <li>{{ $user->email }}</li>
                    </ul>
                @endif

                <!-- Réseaux sociaux -->
                @if($user->socialLinks->isNotEmpty())
                    <ul class="about">
                        <li><span>Réseaux sociaux :</span></li>
                        <div class="social-links">
                            @foreach($user->socialLinks as $socialLink)
                                <a href="{{ $socialLink->url }}"
                                   target="_blank"
                                   class="social-icon {{ strtolower($socialLink->platform) }}"
                                   title="{{ $socialLink->platform }}"
                                   rel="noopener noreferrer">
                                    <i class="fab fa-{{ strtolower($socialLink->platform) }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </ul>
                @endif

                <!-- Message de bienvenue -->
                <div class="content">
                    <p>
                        🎉 Bienvenue ! 🎉<br />
                        Merci d'avoir scanné ma carte de visite. Vous êtes maintenant connecté à toutes mes informations
                        professionnelles !
                    </p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="container text-center mt-5">
                <div class="button-container">
                    @if($user->telephone)
                        <button class="btn btn-primary btn-custom">
                            <a href="tel:{{ $user->telephone }}" style="color: white;">
                                <i class="fas fa-phone"></i> Appeler
                            </a>
                        </button>
                    @endif

                    @if($user->vcard_file)
                        <button class="btn btn-primary btn-custom">
                            <a href="{{ asset('storage/' . $user->vcard_file) }}"
                               download="{{ asset('storage/' . $user->vcard_file) }}"
                               style="color: white;">
                                <i class="fas fa-address-book"></i> Enregistrer
                            </a>
                        </button>
                    @endif

                    @if($user->email)
                        <button class="btn btn-primary btn-custom">
                            <a href="mailto:{{ $user->email }}" style="color: white;">
                                <i class="fas fa-envelope"></i> Envoyer un email
                            </a>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour les éléments au chargement
        const elements = document.querySelectorAll('.img__container, h2, .profession, .about, .social-links, .button-container');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            setTimeout(() => {
                element.style.transition = 'all 0.5s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 200);
        });

        // Gestion des erreurs de chargement d'image
        const profileImage = document.querySelector('.img__container img');
        profileImage.addEventListener('error', function() {
            this.src = '{{ asset('images/default-profile.jpg') }}';
        });
    });
</script>
@endsection
