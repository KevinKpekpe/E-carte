@extends('clients.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">
                        {{ isset($employee) ? 'Modifier un employé' : 'Ajouter un employé' }}
                    </h4>

                    <form
                        action="{{ isset($employee) ? route('entreprise.employees.update', $employee->id) : route('entreprise.employees.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($employee))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                        id="nom" name="nom"
                                        value="{{ old('nom', isset($employee) ? $employee->nom : '') }}">
                                    @error('nom')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                        id="prenom" name="prenom"
                                        value="{{ old('prenom', isset($employee) ? $employee->prenom : '') }}" >
                                    @error('prenom')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', isset($employee) ? $employee->email : '') }}" >
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                        id="telephone" name="telephone"
                                        value="{{ old('telephone', isset($employee) ? $employee->telephone : '') }}"
                                        >
                                    @error('telephone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" class="form-control @error('profession') is-invalid @enderror"
                                id="profession" name="profession"
                                value="{{ old('profession', isset($employee) ? $employee->profession : '') }}" >
                            @error('profession')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo_profile" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control @error('photo_profile') is-invalid @enderror"
                                id="photo_profile" name="photo_profile" accept="image/*">
                            @error('photo_profile')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if (isset($employee) && $employee->photo_profile)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $employee->photo_profile) }}"
                                        alt="Photo de profil actuelle" class="img-thumbnail" style="height: 100px">
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($employee) ? 'Mettre à jour' : 'Ajouter' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
