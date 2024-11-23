@extends('clients.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Modifier mes informations</h4>

                <form action="" method="POST" enctype="multipart/form-data">
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
                        <label for="profession" class="form-label">Profession</label>
                        <input type="text" class="form-control @error('profession') is-invalid @enderror"
                            id="profession" name="profession" value="{{ old('profession', auth()->user()->profession) }}">
                        @error('profession')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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

                    <div class="mb-3">
                        <label class="form-label">Réseaux sociaux</label>
                        <div id="social-links-container">
                            @foreach(auth()->user()->socialLinks as $index => $socialLink)
                                <div class="row social-link-row mb-2">
                                    <div class="col-md-5">
                                        <select name="social_links[{{ $index }}][platform]" class="form-select">
                                            <option value="facebook" {{ $socialLink->platform == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="twitter" {{ $socialLink->platform == 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="google" {{ $socialLink->platform == 'google' ? 'selected' : '' }}>Google</option>
                                            <option value="github" {{ $socialLink->platform == 'github' ? 'selected' : '' }}>GitHub</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[{{ $index }}][url]"
                                            class="form-control" value="{{ $socialLink->url }}"
                                            placeholder="URL du profil social">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-social-link">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-social-link">
                            Ajouter un réseau social
                        </button>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let socialLinksContainer = document.getElementById('social-links-container');
        let addButton = document.getElementById('add-social-link');
        let socialLinkCount = {{ auth()->user()->socialLinks->count() }};

        addButton.addEventListener('click', function() {
            let newRow = `
                <div class="row social-link-row mb-2">
                    <div class="col-md-5">
                        <select name="social_links[${socialLinkCount}][platform]" class="form-select">
                            <option value="facebook">Facebook</option>
                            <option value="twitter">Twitter</option>
                            <option value="google">Google</option>
                            <option value="github">GitHub</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="url" name="social_links[${socialLinkCount}][url]"
                            class="form-control" placeholder="URL du profil social">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-social-link">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            `;
            socialLinksContainer.insertAdjacentHTML('beforeend', newRow);
            socialLinkCount++;
        });

        socialLinksContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-social-link') ||
                e.target.parentElement.classList.contains('remove-social-link')) {
                let row = e.target.closest('.social-link-row');
                row.remove();
            }
        });
    });
</script>
@endsection
