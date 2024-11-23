@extends('admin.app')
@section('title','Profile Modification')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Modifier mes informations</h4>

                <form action="{{route('admin.profil.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                    id="nom" name="nom" value="{{ old('nom', auth()->user()->nom) }}" required>
                                @error('nom')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                    id="prenom" name="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" required>
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
                                <input type="email" class="form-control" id="email"
                                    value="{{ auth()->user()->email }}" disabled>
                                <small class="text-muted">L'email ne peut pas être modifié</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                    id="telephone" name="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" required>
                                @error('telephone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                            id="photo" name="photo" accept="image/*">
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if(auth()->user()->photo_profile)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . auth()->user()->photo_profile) }}"
                                    alt="Photo de profil actuelle" class="img-thumbnail" style="height: 100px">
                            </div>
                        @endif
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
