@extends('auth.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0 mb-3">Vérification d'email requise</h4>
                            <p class="text-muted mb-0 font-13">
                                Un email de vérification a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception pour continuer.
                            </p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger text-center">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control"
                                    placeholder="Votre adresse email" required>
                            </div>
                            <div class="mb-3 text-center d-grid">
                                <button class="btn btn-primary" type="submit">
                                    Renvoyer le lien
                                </button>
                            </div>
                        </form>

                        <div class="mb-3 text-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">
                            Vous avez des problèmes ?
                            <a href="" class="text-dark ms-1">
                                <b>Contactez le support</b>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
