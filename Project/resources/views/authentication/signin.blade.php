<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head/>

<body>

    <section class="auth bg-base d-flex flex-wrap">
        <div class="" style="position: relative; z-index: 10;">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                {{-- <img src="{{ asset('assets/images/auth/No-data-amico.png') }}" alt=""> --}}
                <div class="relative w-full h-screen">
                    <video
                        style="width: 100%; height: 100%; object-fit: cover; position: relative;"
                        autoplay
                        loop
                        muted
                        playsinline
                    >
                        <source src="{{ asset('assets/video/gym.mp4') }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                    {{-- Overlay sombre si besoin --}}
                    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-30"></div>
                </div>
            </div>
        </div>
        <div class="py-32 px-24 d-flex flex-column justify-content-center relative z-10 w-full max-w-md p-8 bg-black bg-opacity-50 rounded-lg shadow-lg backdrop-blur-md" style="position: absolute; top: 0; left: 0; right: 0; z-index: 20; height: 100%;">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    {{-- <a href="{{ route('index') }}" class="mb-40 max-w-290-px">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </a> --}}
                    <h4 class="mb-12 text-white">Connection au compte</h4>
                    <p class="mb-32 text-white text-secondary-light text-lg">Bienvenue, s'il vous plait renseigner vos informations</p>
                </div>
                
                <!-- Afficher l'erreur pour le champ username -->
                @error('username')
                    <div class="mb-16 alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                        {{ $message }}
                        <button class="remove-button text-danger-600 text-xxl line-height-1">
                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                        </button>
                    </div>
                @enderror
                <form action="{{ route('signin') }}", method="POST">
                    @csrf

                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="text" name="username" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Nom d'utilisateur">
                    </div>
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Mot de passe">
                        </div>
                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                    </div>
                    <div class="">
                        <div class="d-flex justify-content-between gap-2">
                            {{-- <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber">
                                <label class="form-check-label" for="remeber">Se souvenir de moi</label>
                            </div> --}}
                            <a  href={{ route('forgotPassword') }} class="text-primary-600 fw-medium">Mot de passe oublié?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"> Se connecter</button>

                    {{-- <div class="mt-32 center-border-horizontal text-center">
                        <span class="bg-base z-1 px-4">Or sign in with</span>
                    </div>
                    <div class="mt-32 d-flex align-items-center gap-3">
                        <button type="button" class="fw-semibold text-primary-light py-16 px-24 w-50 border radius-12 text-md d-flex align-items-center justify-content-center gap-12 line-height-1 bg-hover-primary-50">
                            <iconify-icon icon="ic:baseline-facebook" class="text-primary-600 text-xl line-height-1"></iconify-icon>
                            Google
                        </button>
                        <button type="button" class="fw-semibold text-primary-light py-16 px-24 w-50 border radius-12 text-md d-flex align-items-center justify-content-center gap-12 line-height-1 bg-hover-primary-50">
                            <iconify-icon icon="logos:google-icon" class="text-primary-600 text-xl line-height-1"></iconify-icon>
                            Google
                        </button>
                    </div> --}}
                    {{-- <div class="mt-32 text-center text-sm">
                        <p class="mb-0">Pas encore de compte ? <a  href="{{ route('signup') }}" class="text-primary-600 fw-semibold">S'inscrire</a></p>
                    </div> --}}

                </form>
            </div>
        </div>
    </section>

@php
        $script = '<script>
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

<x-script />

</body>

</html>