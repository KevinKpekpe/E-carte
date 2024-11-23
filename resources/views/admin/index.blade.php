@extends('admin.app')
@section('content')
<div class="row">
    <!-- Total Users Card -->
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                </div>

                <h4 class="header-title mt-0 mb-3">Total Utilisateurs</h4>

                <div class="widget-box-2">
                    <div class="widget-detail-2 text-end">
                        <span class="badge bg-info rounded-pill float-start mt-3">100% <i
                                class="mdi mdi-account-multiple"></i> </span>
                        <h2 class="fw-normal mb-1">{{ $totalUsers }}</h2>
                        <p class="text-muted mb-3">Nombre total d'utilisateurs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                </div>

                <h4 class="header-title mt-0 mb-3">Comptes Actifs</h4>

                <div class="widget-box-2">
                    <div class="widget-detail-2 text-end">
                        <span class="badge bg-success rounded-pill float-start mt-3">{{ $activePercentage }}% <i
                                class="mdi mdi-account-check"></i> </span>
                        <h2 class="fw-normal mb-1">{{ $activeUsers }}</h2>
                        <p class="text-muted mb-3">Utilisateurs actifs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inactive Users Card -->
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                </div>

                <h4 class="header-title mt-0 mb-3">Comptes Inactifs</h4>

                <div class="widget-box-2">
                    <div class="widget-detail-2 text-end">
                        <span class="badge bg-danger rounded-pill float-start mt-3">{{ $inactivePercentage }}% <i
                                class="mdi mdi-account-off"></i> </span>
                        <h2 class="fw-normal mb-1">{{ $inactiveUsers }}</h2>
                        <p class="text-muted mb-3">Utilisateurs inactifs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
