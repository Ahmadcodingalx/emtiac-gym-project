@extends('layout.layout')
@php
    $title='Effectuer une vente';
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

            <form action="{{ route('new-sale') }}" class="card h-100 p-0 radius-12" method="POST">
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
                                    <label for="client" class="form-label fw-semibold text-primary-light text-sm mb-8">Client </label>
                                    <select class="form-control radius-8 form-select" id="client" name="client" required>
                                        <option value="">Sélectionner un client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->lastname }} {{ $client->firstname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="product" class="form-label fw-semibold text-primary-light text-sm mb-8">Produit<span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="product" name="product">
                                        <option value="">Sélectionner un produit</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quantité</label>
                                    <div class="icon-field has-validation">
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Entrer la Quantité" value="1" min="1" required>
                                        <div class="invalid-feedback">
                                            S'il vous plait, remplir ce champ
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button id="addProduct" class="btn btn-primary-600" type="button">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row justify-content-center">
                        <div class="">
                            <div class="card border">
                                
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Quantité</th>
                                                <th>Prix Unitaire</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productList">
                                            <!-- Les produits ajoutés apparaîtront ici -->
                                        </tbody>
                                    </table>
                                    <!-- Total Général -->
                                    <h4>Total: <span id="totalGeneral">0</span> FCFA</h4>

                                    <!-- Champ caché pour envoyer les données des produits -->
                                    <input type="hidden" name="products" id="productsJson">

                                    <button type="submit" class="btn btn-success">Valider la Vente</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>






            <!-- Importation de jQuery -->
            <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

            <script>
                $(document).ready(function () {
                    let products = [];
            
                    $("#addProduct").click(function () {
                        let productId = $("#product").val();
                        let productName = $("#product option:selected").text();
                        let price = parseFloat($("#product option:selected").data("price"));
                        let quantity = parseInt($("#quantity").val());
            
                        if (!productId || quantity < 1) {
                            alert("Sélectionnez un produit et entrez une quantité valide !");
                            return;
                        }
            
                        let total = price * quantity;
            
                        // Ajouter au tableau visuel
                        let line = `<tr>
                            <td>${productName}</td>
                            <td>${quantity}</td>
                            <td>${price} FCFA</td>
                            <td>${total} FCFA</td>
                            <td><button type="button" class="btn btn-danger btn-sm delete">X</button></td>
                        </tr>`;
                        $("#productList").append(line);
            
                        // Ajouter au tableau JS
                        products.push({ product: productId, quantity: quantity, total: total });
            
                        // Mettre à jour le champ caché
                        $("#productsJson").val(JSON.stringify(products));
            
                        // Mettre à jour le total général
                        calculerTotal();
                    });
            
                    // Supprimer un produit
                    $(document).on("click", ".delete", function () {
                        let index = $(this).closest("tr").index();
                        products.splice(index, 1);
                        $(this).closest("tr").remove();
                        $("#productsJson").val(JSON.stringify(products));
                        calculerTotal();
                    });
            
                    function calculerTotal() {
                        let total = products.reduce((sum, p) => sum + (p.total), 0);
                        $("#totalGeneral").text(total);
                    }
                });
            </script>

@endsection

