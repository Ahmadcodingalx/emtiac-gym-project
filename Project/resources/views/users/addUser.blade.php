@extends('layout.layout')
@php
    $title='Add User';
    $subTitle = 'Add User';
    $script = '<script>
                    // ================== Image Upload Js Start ===========================
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
                    // ================== Image Upload Js End ===========================
             </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                    <div class="row justify-content-center">
                        <div class="col-xxl-6 col-xl-8 col-lg-10">
                            <div class="card border">
                                
                                <div class="card-body">
                                    
                                    <form action="{{ route('new-user') }}" method="POST" enctype="multipart/form-data">
                                        <h6 class="text-md text-primary-light mb-16">Image de Profil</h6>
    
                                        <!-- Upload Image Start -->
                                        <div class="mb-24 mt-16">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image" hidden>
                                                    <label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                                        <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                                    </label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Upload Image End -->
                                        @csrf
                                    
                                        <div class="mb-20">
                                            <label for="lastname" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom <span class="text-danger-600">*</span></label>
                                            <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control radius-8" id="lastname" placeholder="Entrer le nom">
                                        </div>
                                        <div class="mb-20">
                                            <label for="firstname" class="form-label fw-semibold text-primary-light text-sm mb-8">Prénom <span class="text-danger-600">*</span></label>
                                            <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control radius-8" id="firstname" placeholder="Enter le prénom">
                                        </div>
                                        {{-- <div class="mb-20">
                                            <label for="username" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom d'utilisateur <span class="text-danger-600">*</span></label>
                                            <input type="text" name="username" class="form-control radius-8" id="username" placeholder="Enter le nom d'utilisateur">
                                        </div> --}}
                                        <div class="mb-20">
                                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                            <input type="email" name="email" value="{{ old('email') }}" class="form-control radius-8" id="email" placeholder="Enter l'adresse email">
                                        </div>
                                        {{-- <div class="mb-20">
                                            <label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">Mot de passe<span class="text-danger-600">*</span></label>
                                            <input type="text" name="password" class="form-control radius-8" id="password" placeholder="Enter le mot de passe">
                                        </div> --}}
                                        <div class="mb-20">
                                            <label for="tel" class="form-label fw-semibold text-primary-light text-sm mb-8">Téléphone</label>
                                            <input type="text" name="tel" value="{{ old('tel') }}" class="form-control radius-8" id="tel" placeholder="Enter le numéro de téléphone">
                                        </div>
                                        {{-- <div class="mb-20">
                                            <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Department <span class="text-danger-600">*</span> </label>
                                            <select class="form-control radius-8 form-select" id="depart">
                                                <option>Enter Event Title </option>
                                                <option>Enter Event Title One </option>
                                                <option>Enter Event Title Two</option>
                                            </select>
                                        </div> --}}
                                        <div class="mb-20">
                                            <label for="sex" class="form-label fw-semibold text-primary-light text-sm mb-8">Genre<span class="text-danger-600">*</span> </label>
                                            <select class="form-control radius-8 form-select" id="sex" name="sex">
                                                <option>Homme</option>
                                                <option>Femme</option>
                                            </select>
                                        </div>
                                        {{-- <div class="mb-20">
                                            <label for="desc" class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                                            <textarea name="#0" class="form-control radius-8" id="desc" placeholder="Write description..."></textarea>
                                        </div> --}}
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Annuler
                                            </button>
                                            <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

