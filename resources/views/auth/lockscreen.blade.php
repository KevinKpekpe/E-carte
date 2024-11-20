@extends('auth.app')
@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0 mb-4">Welcome Back</h4>

                                <p class="text-muted my-4">Entrez votre mot de passe pour vous reconncter.</p>

                            </div>

                            <form action="#">

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required="" id="password"
                                        placeholder="Votre password">
                                </div>

                                <div class="mb-0 text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Connexion </button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Ce n'est pas vous ?  me <a href="pages-login.html"
                                    class="text-dark ms-1"><b>Connecter</b></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
@endsection
