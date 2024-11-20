@extends('auth.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">Connexion</h4>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Adresse email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="emailaddress" name="email" value="{{ old('email') }}" required
                                    placeholder="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    name="password" required id="password" placeholder="mot de passe">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Se rappeler de moi</label>
                                </div>
                            </div>

                            <div class="mb-3 d-grid text-center">
                                <button class="btn btn-primary" type="submit">Connexion</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p><a href="" class="text-dark ms-1">
                                <i class="fa fa-lock me-1"></i>Mot de passe oublié ?</a>
                        </p>
                        <p class="text-muted">Vous n'avez pas de compte ?
                            <a href="" class="text-dark ms-1">
                                <b>Créer mon compte</b>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
