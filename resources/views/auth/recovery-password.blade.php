@extends('auth.app')
@section('content')
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0 mb-3">Recuperation de compte</h4>
                                <p class="text-muted mb-0 font-13">Entrez votre adresse e-mail et nous vous enverrons un e-mail avec des instructions pour réinitialiser votre mot de passe. </p>
                            </div>

                            <form action="#">

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Address mail</label>
                                    <input class="form-control" type="email" id="emailaddress" required=""
                                        placeholder="Votre email">
                                </div>

                                <div class="mb-3 text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Envoyer le lien </button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Me <a href="pages-login.html" class="text-dark ms-1"><b>Connecter </b></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
