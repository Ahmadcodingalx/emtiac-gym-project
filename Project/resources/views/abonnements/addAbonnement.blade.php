@extends('layout.layout')
@php
    $title='Créer un abonnement';
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

            <form action="{{ route('new-abonnement') }}" class="card h-100 p-0 radius-12" method="POST">
                @csrf
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Input Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3 needs-validation align-items-end">
                                <div class="col-md-4">
                                    <label for="client" class="form-label fw-semibold text-primary-light text-sm mb-8">Client <span style="color: rgb(180, 180, 180)">(Facultatif)</span></label>
                                    <select class="form-control radius-8 form-select" id="client" name="client">
                                        <option value="">Sélectionner un client</option>
                                        <option value="{{ null }}">Autre</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->lastname }} {{ $client->firstname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Type d'abonnement <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="type" name="type">
                                        <option value="">Sélectionner un type d'abonnement</option>
                                        <option value="{{ null }}">Autre</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}" >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="service" class="form-label fw-semibold text-primary-light text-sm mb-8">Service <span style="color: rgb(180, 180, 180)">(Facultatif)</span> </label>
                                    <select class="form-control radius-8 form-select" id="service" name="service">
                                        <option value="{{ null }}">Sélectionner un service</option>
                                        {{-- <option value="">Sélectionner un service</option> --}}
                                        <option value="{{ null }}">Autre</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" >{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            </div>
                            <button id="addservice" class="btn btn-primary-600 mt-20" type="submit">Créer</button>
                        </div>
                    </div>
                </div>
            </form>






            <!-- Importation de jQuery -->
            <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

            <script>
                $(document).ready(function () {
                    let services = [];
            
                    $("#addservice").click(function () {
                        let serviceId = $("#service").val();
                        let serviceName = $("#service option:selected").text();
                        let price = parseFloat($("#service option:selected").data("price"));
                        let quantity = parseInt($("#quantity").val());
            
                        let total = price * quantity;
            
                        // Ajouter au tableau visuel
                        let line = `<tr>
                            <td>${serviceName}</td>
                            <td>${quantity}</td>
                            <td>${price} FCFA</td>
                            <td>${total} FCFA</td>
                            <td><button type="button" class="btn btn-danger btn-sm delete">X</button></td>
                        </tr>`;
                        $("#serviceList").append(line);
            
                        // Ajouter au tableau JS
                        services.push({ service: serviceId, quantity: quantity, total: total });
            
                        // Mettre à jour le champ caché
                        $("#servicesJson").val(JSON.stringify(services));
            
                        // Mettre à jour le total général
                        calculerTotal();
                    });
            
                    // Supprimer un produit
                    $(document).on("click", ".delete", function () {
                        let index = $(this).closest("tr").index();
                        services.splice(index, 1);
                        $(this).closest("tr").remove();
                        $("#servicesJson").val(JSON.stringify(services));
                        calculerTotal();
                    });
            
                    function calculerTotal() {
                        let total = services.reduce((sum, p) => sum + (p.total), 0);
                        $("#totalGeneral").text(total);
                    }
                });
                document.getElementById('date_debut').value = new Date().toISOString().split('T')[0];
            </script>

@endsection

