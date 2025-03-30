@extends('layout.layout')
@php
    $title = 'Abonnement';
    $subTitle = 'Abonnement';
    $script = '<script>
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
        <style>
            body { font-family: Arial, sans-serif; }
            .container { width: 80%; margin: auto; padding: 20px; border: 1px solid #000; }
            .title { text-align: center; font-size: 20px; font-weight: bold; }
            .header { text-align: center; font-size: 15px; font-weight: bold; }
            .details { margin-top: 20px; }
            .details p { margin: 5px 0; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; }
        </style>

        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <div class="pb-24 ms-16 mb-24 me-16  mt-100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <h6 class="mb-3 mt-16">{{ $ab->transaction_id }}</h6>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="">Créer par</span>
                            <span class="text-secondary-light fw-medium"> : {{ $ab->createdBy->firstname ?? 'Aucun' }}
                                {{ $ab->createdBy->lastname ?? '' }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class=" ">Modifier par</span>
                            <span class="text-secondary-light fw-medium"> : {{ $ab->updatedBy->firstname ?? 'Personne !' }}
                                {{ $ab->updatedBy->lastname ?? '' }}</span>
                        </li>
                    </div>
                    <div class="mt-24">
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Client</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->client->lastname ?? $ab->lastname }}
                                    {{ $ab->client->firstname ?? $ab->firstname }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Type</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->type->name }} à {{ $ab->type->amount }} fcfa</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Service</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    {{ $ab->service->name ?? 'Aucun' }}</span>
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
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->price ?? $ab->type->amount }}
                                    fcfa</span>
                            </li>
                            @if (!$ab->if_all_pay)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Montant Restant</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $ab->rest }}
                                        fcfa</span>
                                </li>
                            @endif
                            @if ($ab->if_group)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Nombre de Personnes</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $ab->groupes->count() }} </span>
                                </li>
                            @endif
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Statut</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $ab->status }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Remarque</span>
                                <textarea disabled style="border-color: transparent; background-color: transparent;" class="form-control" rows="4"
                                    cols="50">{{ $ab->remark }}</textarea>
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
                    <div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between"
                        role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                            {{ session('success') }}
                        </div>
                        <button class="remove-button text-success-600 text-xxl line-height-1">
                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                        </button>
                    </div>
                @endif
                @if ($errors->has('error'))
                    {{-- <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div> --}}
                    <div class="alert alert-warning bg-warning-100 text-warning-600 border-warning-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between"
                        role="alert">
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
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab"
                                aria-controls="pills-edit-profile" aria-selected="true">
                                Modifier l'abonnement
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab"
                                aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Impression
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <form action="{{ route('update-abonnement', ['id' => $ab->id]) }}" method="POST"
                            class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                            aria-labelledby="pills-edit-profile-tab" tabindex="0" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3 needs-validation align-items-start mt-20">
                                @if ($ab->client)
                                    <div class="col-md-4">
                                        <label for="client"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Client </label>
                                        <select {{ $ab->status === 'actif' ? 'disabled' : ''}} class="form-control radius-8 form-select" id="client" name="client">
                                            <option value="">Sélectionner un client</option>
                                            <option value="">Autre</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ $ab->client_id == $client->id ? 'selected' : '' }}>
                                                    {{ $client->lastname }} {{ $client->firstname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif (!$ab->client && !$ab->if_group)
                                    <div class="row gy-3 needs-validation align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label">Nom <span class="text-danger-600">*</span></label>
                                            <input type="text" name="lastname" id="lastname" class="form-control"
                                                placeholder="Entrer le nom..." required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Prénom <span class="text-danger-600">*</span></label>
                                            <input type="text" name="firstname" id="firstname" class="form-control"
                                                placeholder="Entrer le prénom..." required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Téléphone <span class="text-danger-600">*</span></label>
                                            <input type="text" name="tel" id="tel" class="form-control"
                                                placeholder="Entrer le numéro de tel..." required>
                                        </div>
                                    </div>
                                @elseif ($ab->if_group)
                                    <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                                        <div class="pb-24 ms-16 mb-24 me-16  mt-100">
                                            <h5>Membres du groupe ( {{ $ab->groupes->count() }} ) :</h5>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Téléphone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ab->groupes as $group)
                                                        <tr>
                                                            <td>{{ $group->lastname }}</td>
                                                            <td>{{ $group->firstname }}</td>
                                                            <td>{{ $group->tel }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <label for="client"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Type </label>
                                    <select {{ $ab->status === 'actif' ? 'disabled' : ''}} class="form-control radius-8 form-select" id="client" name="type"
                                        required>
                                        <option value="">Sélectionner un type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $ab->type_id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="client"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Service </label>
                                    <select {{ $ab->status === 'actif' ? 'disabled' : ''}} class="form-control radius-8 form-select" id="client" name="service">
                                        <option value="">Sélectionner un service</option>
                                        <option value="">Autre</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $ab->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Prix </label>
                                    <input {{ $ab->status === 'actif' ? 'disabled' : ''}} type="number" name="price" id="price" class="form-control"
                                        placeholder="Entrer le prix">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date de début <span
                                            class="text-danger-600">*</span></label>
                                    <div class="icon-field has-validation">
                                        <input {{ $ab->status === 'actif' ? 'disabled' : ''}} type="date" value="{{ $ab->start_date }}" name="start_date"
                                            id="start_date" class="form-control" required>
                                        <div class="invalid-feedback">
                                            S'il vous plait, remplir ce champ
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Remarque </label>
                                    <div class="icon-field has-validation">
                                        <textarea
                                            {{ $ab->status === 'actif' ? 'disabled' : ''}}
                                            style="background-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"
                                            name="remark" class="form-control" rows="4" cols="50" placeholder="Enter une remarque...">{{ $ab->remark }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button id="addservice" class="btn btn-primary-600 mt-20"
                                type="submit">Modifier</button>
                        </form>

                        <div class="tab-pane fade" id="pills-notification" role="tabpanel"
                            aria-labelledby="pills-notification-tab" tabindex="0">
                            <div class="container">
                                <div class="title">
                                    Gym H
                                </div>
                                <div class="header">
                                    Reçu d'Abonnement N° {{ $ab->transaction_id }}
                                </div>
                        
                                <div class="details">
                                    <p><strong>Date et heure:</strong> {{ now()->format('d/m/Y') }}</p>
                                    @if ($ab->if_group)
                                        <p><strong>Nombre de personnes:</strong> {{ $ab->groupes->count() }} </p>
                                    @else
                                        <p><strong>Nom et prénom:</strong> {{ $ab->client->firstname ?? $ab->firstname }} {{ $ab->client->lastname ?? $ab->lastname }}</p>
                                    @endif
                                    <p><strong>Type d'abonnement:</strong> {{ $ab->type->name }} à {{ $ab->type->amount }} fcfa    
                                        @if ($ab->if_group)
                                            --------- <span style="font-size: 15px" class="text-neutral-600">( en groupe ) </span>
                                        @endif
                                    </p>
                                    <p><strong>Payé:</strong> {{ number_format($ab->price ?? $ab->type->amount, 2) }} fcfa</p>
                                    @if (!$ab->if_all_pay)
                                        <p><strong>Reste:</strong> {{ number_format($ab->rest, 2) }} fcfa --------- <span style="font-size: 15px" class="text-neutral-600">( à terminer avant le {{ $ab->end_pay_date }} ) </span></p>
                                    @endif
                                    <p><strong>Date de début:</strong> {{ $ab->start_date }}</p>
                                    <p><strong>Date de fin:</strong> {{ $ab->end_date }}</p>
                                    {{-- <p><strong>Nombre de séances restantes:</strong> {{ $ab->type->name ?? 'N/A' }}</p> --}}
                                    <p><strong>mode de paiemant:</strong> Espèces</p>
                                    <p><strong>Service:</strong> {{ $ab->service->name ?? 'Aucun' }}</p>
                                    <p><strong>Responsable de l'enregistrement:</strong> {{ $ab->createdBy->firstname ?? 'Aucun' }}
                                        {{ $ab->createdBy->lastname ?? '' }}</p>
                                    <p><strong>Adresse:</strong> Lomé</p>
                                    <p><strong>Contact:</strong> +228 96891550 / moroumamam53@gmail.com</p>
                                </div>
                        
                                <div class="footer">
                                    Condition d'utilisation <br>
                                    -Ce ticket est personnel et non transférable <br>
                                    -Présentation obligatoire à l'entrée <br>
                                    -Valable jusqu'à expiration de l'abonnement <br><br>
                                    Merci pour votre confiance ! 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
