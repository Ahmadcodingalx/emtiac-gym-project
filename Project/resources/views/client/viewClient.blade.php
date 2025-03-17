@extends('layout.layout')
@php
    $title='View Profile';
    $subTitle = 'View Profile';
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
                    $("#imageUpload").change(function() {
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
                <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="{{ asset('assets/images/user-grid/user-grid-img14.png') }}" alt="" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16">{{ $client->identifiant }}</h6>
                        <span class="text-secondary-light mb-16">{{ $client->email }}</span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Information personnelles</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Nom</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $client->lastname }} {{ $client->firstname }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $client->email }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Téléphone</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $client->tel }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Addresse</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $client->address == null ? "***" : $client->address}}</span>
                            </li>
                            @if ($client->sex == true)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Sex</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Homme</span>
                                </li>
                            @elseif ($client->sex == false)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Sex</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Femme</span>
                                </li>
                            @else
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Sex</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Anonime</span>
                                </li>
                            @endif
                            {{-- <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Department</span>
                                <span class="w-70 text-secondary-light fw-medium">: Design</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Designation</span>
                                <span class="w-70 text-secondary-light fw-medium">: UI UX Designer</span>
                            </li>
                            <li class="d-flex align-items-center gap-1">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Bio</span>
                                <span class="w-70 text-secondary-light fw-medium">: Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                            </li> --}}
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
                                Modifier le Client
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                Changer le mot de passe
                            </button>
                        </li> --}}
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Notification Settings
                            </button>
                        </li> --}}
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{ route('update-client') }}" method="POST" class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                            @csrf
                            @method('PUT')
                            <h6 class="text-md text-primary-light mb-16">Image</h6>
                            <!-- Upload Image Start -->
                            <div class="mb-24 mt-16">
                                <div class="avatar-upload">
                                    <div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                        <input type="hidden" name="id" value={{ $client->id }}>
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden>
                                        <label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                            <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                        </label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Upload Image End -->
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="lastname" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom <span class="text-danger-600">*</span></label>
                                        <input type="text" name="lastname" value={{ $client->lastname }} class="form-control radius-8" id="lastname" placeholder="Entrez votre nom">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="firstname" class="form-label fw-semibold text-primary-light text-sm mb-8">Prénom <span class="text-danger-600">*</span></label>
                                        <input type="text" name="firstname" value={{ $client->firstname }} class="form-control radius-8" id="firstname" placeholder="Entrez votre prénom">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="username" class="form-label fw-semibold text-primary-light text-sm mb-8">Identifiant <span class="text-danger-600">*</span></label>
                                        <input disabled type="text" name="username" value={{ $client->identifiant }} class="form-control radius-8" id="username" placeholder="Entrez votre Nom d'utilisateur">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                        <input type="email" name="email" value={{ $client->email }} class="form-control radius-8" id="email" placeholder="Entez votre email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="tel" class="form-label fw-semibold text-primary-light text-sm mb-8">Téléphone</label>
                                        <input type="text" name="tel" value={{ $client->tel }} class="form-control radius-8" id="tel" placeholder="Entez le numéro de téléphone">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">Addresse</label>
                                        <input type="text" name="address" value={{ $client->address == null ? "***" : ($client->address === "***" ? "***" : $client->address)}} class="form-control radius-8" id="tel" placeholder="Entez votre address">
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">Addresse</label>
                                        <input type="text" name="address" value={{ $client->address }} class="form-control radius-8" id="address" placeholder="Entez votre address">
                                    </div>
                                </div> --}}
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="sex" class="form-label fw-semibold text-primary-light text-sm mb-8">Genre <span class="text-danger-600">*</span> </label>
                                        <select name="sex" val class="form-control radius-8 form-select" id="sex">
                                            @if ($client->sex == true)
                                                <option>Homme</option>
                                                <option>Femme</option>
                                                <option>Selectionner</option>
                                            @elseif ($client->sex == false)
                                                <option>Femme</option>
                                                <option>Homme</option>
                                                <option>Selectionner</option>
                                            @else
                                                <option>Selectionner</option>
                                                <option>Femme</option>
                                                <option>Homme</option>
                                            @endif
                                            {{-- <option>Enter Event Title Two</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                {{-- <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                    Cancel
                                </button> --}}
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                    Modifier
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
