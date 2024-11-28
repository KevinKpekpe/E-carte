@extends('clients.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="mt-3 mt-md-0">
                                <a href="{{ route('entreprise.employees.create') }}"
                                    class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-plus-circle me-1"></i> Ajouter un employé
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form class="d-flex flex-wrap align-items-center justify-content-sm-end" method="GET"
                                action="{{ route('entreprise.employees.index') }}">
                                <label for="sort" class="me-2">Trier par</label>
                                <div class="me-sm-2">
                                    <select class="form-select my-1 my-md-0" id="sort" name="sort">
                                        <option value="">Tous</option>
                                        <option value="1" {{ request('sort') == '1' ? 'selected' : '' }}>Nom</option>
                                        <option value="2" {{ request('sort') == '2' ? 'selected' : '' }}>Profession
                                        </option>
                                        <option value="3" {{ request('sort') == '3' ? 'selected' : '' }}>Statut
                                        </option>
                                    </select>
                                </div>
                                <label for="search" class="visually-hidden">Rechercher</label>
                                <div class="d-flex">
                                    <input type="search" class="form-control my-1 my-md-0" id="search" name="search"
                                        placeholder="Rechercher..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom complet</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Profession</th>
                                    <th>Date d'expiration</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            @if ($employee->photo_profile)
                                                <img src="{{ Storage::url($employee->photo_profile) }}" alt="photo"
                                                    class="rounded-circle me-2" width="32">
                                            @endif
                                            {{ $employee->nom }} {{ $employee->prenom }}
                                        </td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->telephone }}</td>
                                        <td>{{ $employee->profession }}</td>
                                        <td>{{ $employee->expiration_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $employee->is_active ? 'success' : 'danger' }}">
                                                {{ $employee->is_active ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('entreprise.employees.edit', $employee) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('entreprise.employees.destroy', $employee) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ Storage::url($employee->vcard_file) }}" class="btn btn-sm btn-info"
                                                download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{route('employe.service.show',$employee->slug)}}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun employé trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
