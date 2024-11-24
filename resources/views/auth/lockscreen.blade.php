@extends('auth.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0 mb-4">Bon Retour Chez vous !!</h4>
                        <p class="text-muted my-4">Entrez votre mot de passe pour vous reconnecter.</p>
                    </div>

                    <form action="{{ route('lockscreen.unlock') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                type="password"
                                required
                                id="password"
                                name="password"
                                placeholder="Votre password">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-0 text-center d-grid">
                            <button class="btn btn-primary" type="submit">Connexion</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        Ce n'est pas vous ?
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-dark ms-1">
                            <b>Se déconnecter</b>
                        </a>
                    </p>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
