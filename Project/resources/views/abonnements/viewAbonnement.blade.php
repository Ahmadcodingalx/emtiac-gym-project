@extends('layout.layout')
@php
    $title='Abonnement';
    $subTitle = 'Abonnement';
    $script ='<script>
                    // ======================== Upload Image Start =====================
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                                $("#imagePreview").hide();
                                $("#imagePreview").fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#image").change(function() {
                        readURL(this);
                    });
                    // ======================== Upload Image End =====================

                    // ================== Password Show Hide Js Start ==========
                    function initializePasswordToggle(toggleSelector) {
                        $(toggleSelector).on("click", function() {
                            $(this).toggleClass("ri-eye-off-line");
                            var input = $($(this).attr("data-toggle"));
                            if (input.attr("type") === "password") {
                                input.attr("type", "text");
                            } else {
                                input.attr("type", "password");
                            }
                        });
                    }
                    // Call the function
                    initializePasswordToggle(".toggle-password");
                    // ========================= Password Show Hide Js End ===========================
            </script>';
@endphp

@section('content')

    <div class="row gy-4">
            
        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <div class="pb-24 ms-16 mb-24 me-16  mt-100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <h6 class="mb-3 mt-16">{{ $ab->transaction_id }}</h6>
                        <h6 class="mb-3 mt-16">Créer par {{ $user->firstname }}</h6>
                    </div>
                    <div class="mt-24">
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Client</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->id }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Type</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->id }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Service</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->id }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Date de debut</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->start_date }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Date de fin</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->end_date }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Montant payé</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->price }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Statut</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->status }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Remarque</span>
                                <textarea disabled style="border-color: transparent; background-color: transparent;" class="form-control" rows="4" cols="50">{{ $ab->remark }}</textarea>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                @if (session('success'))
                    {{-- <div class="alert alert-success">
                        {{ session('success') }}
                    </div> --}}
                    <div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                            {{ session('success') }}
                        </div>
                        <button class="remove-button text-success-600 text-xxl line-height-1">
                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                        </button>
                    </div>
                @endif
                @if($errors->has('error'))
                    {{-- <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div> --}}
                    <div class="alert alert-warning bg-warning-100 text-warning-600 border-warning-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
                            {{ $errors->first('error') }}
                        </div>
                        <button class="remove-button text-warning-600 text-xxl line-height-1">
                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                        </button>
                    </div>
                @endif
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                                Modifier l'abonnement
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Notification Settings
                            </button>
                        </li> --}}
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{ route('update-client') }}" method="POST" class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row gy-3 needs-validation align-items-start mt-20">
                                <div class="col-md-4">
                                    <label class="form-label">Prix <span style="color: rgb(180, 180, 180)">(Si différent du prix habituel)</span></label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Entrer le prix" >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date de début <span class="text-danger-600">*</span></label>
                                    <div class="icon-field has-validation">
                                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                                        <div class="invalid-feedback">
                                            S'il vous plait, remplir ce champ
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Remarque <span style="color: rgb(180, 180, 180)">(Facultatif)</span></label>
                                    <div class="icon-field has-validation">
                                        <textarea style="background-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"  name="remark" class="form-control" rows="4" cols="50" placeholder="Enter une remarque..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-3 needs-validation align-items-start mt-20">
                                {{-- <div class="col-md-4">
                                    <label class="form-label">Mode de payement <span style="color: rgb(180, 180, 180)">(Si différent du prix habituel)</span></label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Entrer le prix" >
                                </div> --}}
                                <div class="col-md-4">
                                    <label class="form-label">Activer maintenant </label>
                                    <div class="d-flex align-items-center flex-wrap gap-28 mt-10">
                                        <div class="form-check checked-warning d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="radio" id="radio44">
                                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="radio44"> Non </label>
                                        </div>
                                        <div class="form-check checked-success d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="radio" id="radio33">
                                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="radio33"> Oui </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="addservice" class="btn btn-primary-600 mt-20" type="submit">Créer</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
