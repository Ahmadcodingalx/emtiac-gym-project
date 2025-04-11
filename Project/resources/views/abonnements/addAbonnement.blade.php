@extends('layout.layout')
@php
    $title = 'Créer un abonnement';
    $subTitle = 'Vente';
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
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- Select2 CSS + JS -->
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

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
        <div class="">
            <div class="card">
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-client-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-client" type="button" role="tab"
                                aria-controls="pills-client" aria-selected="true">
                                Client inscrit 
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-other-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-other" type="button" role="tab"
                                aria-controls="pills-other" aria-selected="false" tabindex="-1">
                                Autre personne
                            </button>
                        </li>
                        @if (Auth::check() && Auth::user()->is_admin == true)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24" id="pills-group-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-group" type="button" role="tab"
                                    aria-controls="pills-group" aria-selected="false" tabindex="-1">
                                    Groupe
                                </button>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{ route('new-abonnement') }}" method="POST" class="tab-pane fade show active"
                            id="pills-client" role="tabpanel" aria-labelledby="pills-client-tab" tabindex="0">
                            @csrf
                            <div class="card-body">
                                <div class="row gy-3 needs-validation align-items-end">
                                    <div class="col-md-4">
                                        <label for="client"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Client </label>
                                        <select class="form-control radius-8 form-select" id="client" name="client" required>
                                            <option value="">Sélectionner un client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->lastname }}
                                                    {{ $client->firstname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="type"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Type d'abonnement
                                            <span class="text-danger-600">*</span> </label>
                                        <select class="form-control radius-8 form-select" id="type" name="type">
                                            <option value="">Sélectionner un type d'abonnement</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }} à {{ $type->amount }} fcfa</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="service"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Service <span
                                                style="color: rgb(180, 180, 180)">(Facultatif)</span> </label>
                                        <select class="form-control radius-8 form-select" id="service" name="service">
                                            <option value="{{ null }}">Sélectionner un service</option>
                                            {{-- <option value="">Sélectionner un service</option> --}}
                                            <option value="{{ null }}">Autre</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row gy-3 needs-validation align-items-start mt-20">
                                    <div class="col-md-4">
                                        <label class="form-label">Prix <span style="color: rgb(180, 180, 180)">(Si
                                                différent du prix habituel)</span></label>
                                        <input type="number" name="price" id="price" class="form-control"
                                            placeholder="Entrer le prix" value="{{ old('price') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date de début <span
                                                class="text-danger-600">*</span></label>
                                        <div class="icon-field has-validation">
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                required value="{{ old('start_date') }}">
                                            <div class="invalid-feedback">
                                                S'il vous plait, remplir ce champ
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Remarque <span
                                                style="color: rgb(180, 180, 180)">(Facultatif)</span></label>
                                        <div class="icon-field has-validation">
                                            <textarea
                                                style="background-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"
                                                name="remark" class="form-control" rows="4" cols="50" placeholder="Enter une remarque..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card h-100 p-0">
                                    <div class="card-header border-bottom bg-base py-16 px-24">
                                        <h6 class="text-lg fw-semibold mb-0">Payement <span class="text-danger-600">*</span></h6>
                                    </div>
                                    <div class="card-body p-24">
                                        <div class="d-flex align-items-start flex-column flex-wrap gap-3">
                                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_type" id="total" value="total">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="total"> Total </label>
                                            </div>
                                            <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_type" id="partial" value="partial">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="partial"> Partiel </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button id="addservice" class="btn btn-primary-600 mt-20" type="submit">Créer</button>
                            </div>
                        </form>

                        <form action="{{ route('new-abonnement') }}" method="POST" class="tab-pane fade"
                            id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab"
                            tabindex="0">
                            @csrf
                            <div class="card-body">
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
                                <div class="row gy-3 needs-validation align-items-end mt-20">
                                    
                                    <div class="col-md-4">
                                        <label for="type"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8"> Type d'abonnement
                                            <span class="text-danger-600">*</span> </label>
                                        <select class="form-control radius-8 form-select" id="type" name="type">
                                            <option value="">Sélectionner un type d'abonnement</option>
                                            @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }} à {{ $type->amount }} fcfa</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="service"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Service <span
                                                style="color: rgb(180, 180, 180)">(Facultatif)</span> </label>
                                        <select class="form-control radius-8 form-select" id="service" name="service">
                                            <option value="{{ null }}">Sélectionner un service</option>
                                            {{-- <option value="">Sélectionner un service</option> --}}
                                            <option value="{{ null }}">Autre</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Prix <span style="color: rgb(180, 180, 180)">(Si
                                                différent du prix habituel)</span></label>
                                        <input type="number" name="price" id="price" class="form-control"
                                            placeholder="Entrer le prix">
                                    </div>
                                </div>
                                <div class="row gy-3 needs-validation align-items-start mt-20">
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Date de début <span
                                                class="text-danger-600">*</span></label>
                                        <div class="icon-field has-validation">
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                required>
                                            <div class="invalid-feedback">
                                                S'il vous plait, remplir ce champ
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Remarque <span
                                                style="color: rgb(180, 180, 180)">(Facultatif)</span></label>
                                        <div class="icon-field has-validation">
                                            <textarea
                                                style="background-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"
                                                name="remark" class="form-control" rows="4" cols="50" placeholder="Enter une remarque..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-header border-bottom bg-base py-16 px-24">
                                            <h6 class="text-lg fw-semibold mb-0">Payement <span class="text-danger-600">*</span></h6>
                                        </div>
                                        <div class="card-body p-24">
                                            <div class="d-flex align-items-start flex-column flex-wrap gap-3">
                                                <div class="form-check checked-primary d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="payment_type" id="total" value="total">
                                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="total"> Total </label>
                                                </div>
                                                <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" name="payment_type" id="partial" value="partial">
                                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="partial"> Partiel </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button id="addservice" class="btn btn-primary-600 mt-20" type="submit">Créer</button>
                            </div>
                        </form>
                        @if (Auth::check() && Auth::user()->is_admin == true)
                            <form action="{{ route('new-abonnement') }}" method="POST" class="tab-pane fade"
                                id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab"
                                tabindex="0">
                                @csrf
                                <input type="hidden" name="if_group" value="1">
                                <div class="card-body p-24">
                                    <div class="row justify-content-center">
                                        <div class="">
                                            <div class="card border">
                                                
                                                <div class="card-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Prénom</th>
                                                                <th>Téléphone</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="memberList">
                                                            <!-- Les membres ajoutés apparaîtront ici -->
                                                        </tbody>
                                                    </table>
                                                    <!-- Total Général -->
                                                    {{-- <h4>Total: <span id="totalGeneral">0</span> FCFA</h4> --}}
                
                                                    <!-- Champ caché pour envoyer les données des membres -->
                                                    <input type="hidden" name="members" id="membersJson">
                
                                                    {{-- <button type="submit" class="btn btn-success">Valider la Vente</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="row gy-3 needs-validation align-items-end">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Nom <span class="text-danger-600">*</span></label>
                                                        <input type="text" name="lastname2" id="lastname2" class="form-control"
                                                            placeholder="Entrer le nom..." required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Prénom <span class="text-danger-600">*</span></label>
                                                        <input type="text" name="firstname2" id="firstname2" class="form-control"
                                                            placeholder="Entrer le prénom..." required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="text" name="tel2" id="tel2" class="form-control"
                                                            placeholder="Entrer le numéro de tel...">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>&nbsp;</label>
                                                        <button id="addMember" class="btn btn-primary-600" type="button">Ajouter</button>
                                                    </div>
                                                </div>
                                                <div class="row gy-3 needs-validation align-items-end mt-20">
                                                    
                                                    <div class="col-md-4">
                                                        <label for="type"
                                                            class="form-label fw-semibold text-primary-light text-sm mb-8"> Type d'abonnement
                                                            <span class="text-danger-600">*</span> </label>
                                                        <select class="form-control radius-8 form-select" id="type" name="type">
                                                            <option value="">Sélectionner un type d'abonnement</option>
                                                            @foreach ($types as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }} à {{ $type->amount }} fcfa</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="service"
                                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Service <span
                                                                style="color: rgb(180, 180, 180)">(Facultatif)</span> </label>
                                                        <select class="form-control radius-8 form-select" id="service" name="service">
                                                            <option value="{{ null }}">Sélectionner un service</option>
                                                            {{-- <option value="">Sélectionner un service</option> --}}
                                                            <option value="{{ null }}">Autre</option>
                                                            @foreach ($services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Prix <span style="color: rgb(180, 180, 180)">(Si
                                                                différent du prix habituel)</span></label>
                                                        <input type="number" name="price" id="price" class="form-control"
                                                            placeholder="Entrer le prix">
                                                    </div>
                                                </div>
                                                <div class="row gy-3 needs-validation align-items-start mt-20">
                                                    
                                                    <div class="col-md-4">
                                                        <label class="form-label">Date de début <span
                                                                class="text-danger-600">*</span></label>
                                                        <div class="icon-field has-validation">
                                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                                required>
                                                            <div class="invalid-feedback">
                                                                S'il vous plait, remplir ce champ
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Remarque <span
                                                                style="color: rgb(180, 180, 180)">(Facultatif)</span></label>
                                                        <div class="icon-field has-validation">
                                                            <textarea
                                                                style="background-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"
                                                                name="remark" class="form-control" rows="4" cols="50" placeholder="Enter une remarque..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card-header border-bottom bg-base py-16 px-24">
                                                            <h6 class="text-lg fw-semibold mb-0">Payement <span class="text-danger-600">*</span></h6>
                                                        </div>
                                                        <div class="card-body p-24">
                                                            <div class="d-flex align-items-start flex-column flex-wrap gap-3">
                                                                <div class="form-check checked-primary d-flex align-items-center gap-2">
                                                                    <input class="form-check-input" type="radio" name="payment_type" id="total" value="total">
                                                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="total"> Total </label>
                                                                </div>
                                                                <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                                                    <input class="form-check-input" type="radio" name="payment_type" id="partial" value="partial">
                                                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="partial"> Partiel </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button id="addservice" class="btn btn-primary-600 mt-20" type="submit">Créer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- Importation de jQuery -->
    {{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script> --}}

    <script>
        // $(document).ready(function() {
        //     let services = [];

        //     $("#addservice").click(function() {
        //         let serviceId = $("#service").val();
        //         let serviceName = $("#service option:selected").text();
        //         let price = parseFloat($("#service option:selected").data("price"));
        //         let quantity = parseInt($("#quantity").val());

        //         let total = price * quantity;

        //         // Ajouter au tableau visuel
        //         let line = `<tr>
        //                     <td>${serviceName}</td>
        //                     <td>${quantity}</td>
        //                     <td>${price} FCFA</td>
        //                     <td>${total} FCFA</td>
        //                     <td><button type="button" class="btn btn-danger btn-sm delete">X</button></td>
        //                 </tr>`;
        //         $("#serviceList").append(line);

        //         // Ajouter au tableau JS
        //         services.push({
        //             service: serviceId,
        //             quantity: quantity,
        //             total: total
        //         });

        //         // Mettre à jour le champ caché
        //         $("#servicesJson").val(JSON.stringify(services));

        //         // Mettre à jour le total général
        //         calculerTotal();
        //     });

        //     // Supprimer un produit
        //     $(document).on("click", ".delete", function() {
        //         let index = $(this).closest("tr").index();
        //         services.splice(index, 1);
        //         $(this).closest("tr").remove();
        //         $("#servicesJson").val(JSON.stringify(services));
        //         calculerTotal();
        //     });

        //     function calculerTotal() {
        //         let total = services.reduce((sum, p) => sum + (p.total), 0);
        //         $("#totalGeneral").text(total);
        //     }
        // });

        // document.getElementById('date_debut').value = new Date().toISOString().split('T')[0];

        $(document).ready(function () {
            let members = [];
    
            $("#addMember").click(function () {
                // let memberId = $("#member").val();
                let memberFirstname = $("#firstname2").val();
                let memberLastname = $("#lastname2").val();
                let memberTel = $("#tel2").val();
    
                // Ajouter au tableau visuel
                let line = `<tr>
                    <td>${memberLastname}</td>
                    <td>${memberFirstname}</td>
                    <td>${memberTel}</td>
                    <td><button type="button" class="btn btn-danger btn-sm delete">X</button></td>
                </tr>`;
                $("#memberList").append(line);
    
                // Ajouter au tableau JS
                members.push({ firstname: memberFirstname, lastname: memberLastname, tel: memberTel });
    
                // Mettre à jour le champ caché
                $("#membersJson").val(JSON.stringify(members));
    
                // Mettre à jour le total général
                // calculerTotal();
            });
    
            // Supprimer un membre
            $(document).on("click", ".delete", function () {
                let index = $(this).closest("tr").index();
                members.splice(index, 1);
                $(this).closest("tr").remove();
                $("#membersJson").val(JSON.stringify(members));
                // calculerTotal();
            });
    
            // function calculerTotal() {
            //     let total = products.reduce((sum, p) => sum + (p.total), 0);
            //     $("#totalGeneral").text(total);
            // }
        });
    </script>


<script>
    const clientInput = document.getElementById('client');
    const clientChoices = new Choices(clientInput, {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: "Sélectionner un client",
    });

    const typeInput = document.getElementById('type');
    const typeChoices = new Choices(typeInput, {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: "Sélectionner un type",
    });

    const serviceInput = document.getElementById('service');
    const serviceChoices = new Choices(serviceInput, {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: "Sélectionner un service",
    });
</script>



{{-- <script>
    $(document).ready(function() {
        $('#client').select2({
            placeholder: "Sélectionner un client",
            width: '100%',
            allowClear: true // Permet de vider la sélection
        });
    });
</script> --}}

@endsection
