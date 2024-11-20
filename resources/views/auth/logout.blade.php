@extends('auth.app')
@section('content')
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="mt-4">
                                    <div class="logout-checkmark">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                            <circle class="path circle" fill="none" stroke="#4bd396" stroke-width="6"
                                                stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                                            <polyline class="path check" fill="none" stroke="#4bd396" stroke-width="6"
                                                stroke-linecap="round" stroke-miterlimit="10"
                                                points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                                        </svg>
                                    </div>
                                </div>

                                <h3>See you again !</h3>

                                <p class="text-muted"> Vous etes maintenant déconnecté. </p>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Me <a href="{{route('login')}}" class="text-dark ms-1"><b>Connecter</b></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection
