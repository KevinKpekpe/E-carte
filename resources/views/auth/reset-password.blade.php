@extends('auth.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0 mb-3">Réinitialisation du mot de passe</h4>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   type="email"
                                   id="email"
                                   name="email"
                                   value="{{ $email ?? old('email') }}"
                                   required
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                   type="password"
                                   id="password"
                                   name="password"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input class="form-control"
                                   type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>

                        <div class="mb-3 text-center d-grid">
                            <button class="btn btn-warning" type="submit">Réinitialiser le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
