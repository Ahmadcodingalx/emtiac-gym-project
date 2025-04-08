<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head />
@php
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
<body>

    <section class="auth forgot-password-page bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="{{ asset('assets/images/auth/forgot-pass-img.png') }}" alt="">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <h4 class="mb-12">Réinitialiser le mot de passe</h4>
                    <p class="mb-32 text-secondary-light text-lg">Entrer l'email associée à votre compte pour recevoir le code de réinitialisation.</p>
                </div>
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
                <form id="form1" method="POST" action="{{ route('sendOtpEmail') }}">
                    @csrf
                    <div class="icon-field pt-10">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" name="email" id="email1" value='{{ old("email") }}' class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Enter Email" required>
                    </div>
                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Continue</button>
                    <button type="bouton" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" data-bs-toggle="modal" data-bs-target="#exampleModal">Vérifier</button>

                    <div class="text-center">
                    <a  href="{{ route('login') }}" class="text-primary-600 fw-bold mt-24">Retour à la page de connexion</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
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
        <div class="modal-dialog modal-dialog modal-dialog-centered pt-10">
            <div class="modal-content radius-16 bg-base">
                <form class="modal-body p-40 text-center"  id="form2" method="POST" action="{{ route('checkOtpCode') }}"  autocomplete="off">
                    @csrf
                    <div class="mb-32">
                        <img src="{{ asset('assets/images/auth/envelop-icon.png') }}" alt="">
                    </div>
                    <h6 class="mb-12">Confirmer le code</h6>
                    <div class="icon-field">
                        <input type="email" name="change_password_email" id="change_password_email" autocomplete="off" class="form-control h-56-px bg-neutral-50 radius-12 pt-10" placeholder="">
                        <input type="text" name="otp_code" class="form-control h-56-px bg-neutral-50 radius-12 pt-10" placeholder="Ente le code">
                        <div class="mb-20">
                            <div class="position-relative">
                                <input type="password" name="new_access_key" class="form-control radius-8 pt-10" id="new_access_key" autocomplete="new-password" placeholder="Entrez le nouveau mot de passe">
                                <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#new_password"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Confirmer</button>
                </form>
            </div>
        </div>
    </div>

<x-script/>

<script>
// Récupérer l'email du premier formulaire au moment de la soumission du second
document.getElementById('form2').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la soumission du formulaire

    const email1 = document.getElementById('email1').value;
    document.getElementById('change_password_email').value = email1; // Copie la valeur dans le second formulaire

    // Soumettre ensuite le deuxième formulaire
    this.submit();
});
</script>

</body>

</html>