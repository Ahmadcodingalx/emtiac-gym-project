@extends('layout.layout')
@php
    $title='Info vente';
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

            <div class="card h-100 p-0 radius-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex" style="">
                            <h5 class="card-title mb-0">Vente du <span class="text-danger-600">{{ $sale->created_at }}</span></h5>
                            {{-- <h5 class="card-title mb-0">Vente du <span class="text-danger-600">{{ $sale->created_at }}</span></h5> --}}
                        </div>
                        <div class="">
                            <div class="card h-100">
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
                                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                                                Détails de la vente
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link d-flex align-items-center px-24" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                                Modifier la vente
                                            </button>
                                        </li>
                                        {{-- <li class="nav-item" role="presentation">
                                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                                Notification Settings
                                            </button>
                                        </li> --}}
                                    </ul>
                
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                            <div class="d-flex align-items-center justify-content-end gap-3">
                                                {{-- <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                    Supprimer
                                                </button> --}}
                                                <button type="submit" class="mb-10 btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                    Imprimer
                                                </button>
                                            </div>
                                            <div class="">
                                                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                                                    <div class="pb-24 ms-16 mb-24 me-16  mt-100">
                                                        <div class="mt-24">
                                                            <li class="d-flex align-items-center gap-1">
                                                                <h6 class="text-xl w-30">Client </h6>
                                                                {{-- <span class="w-30 text-md fw-semibold text-primary-light">Nom</span> --}}
                                                                <p class="w-70" style="font-size: 16px; font-weight: bold;">: {{ $sale->client->lastname }} {{ $sale->client->firstname }}</p>
                                                            </li>
                                                            <li class="d-flex align-items-center gap-1 mb-12">
                                                                <h6 class="text-xl w-30">Totale </h6>
                                                                {{-- <span class="w-30 text-md fw-semibold text-primary-light">Nom</span> --}}
                                                                <h6 class="w-70">: {{ number_format($sale->total, 2) }} fcfa</h6>
                                                            </li>
                                                            {{-- <ul>
                                                                <li class="d-flex align-items-center gap-1 mb-12">
                                                                    <span class="w-30 text-md fw-semibold text-primary-light">Nom</span>
                                                                    <span class="w-70 text-secondary-light fw-medium">: ***</span>
                                                                </li>
                                                                <li class="d-flex align-items-center gap-1 mb-12">
                                                                    <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                                                    <span class="w-70 text-secondary-light fw-medium">: ***</span>
                                                                </li>
                                                                <li class="d-flex align-items-center gap-1 mb-12">
                                                                    <span class="w-30 text-md fw-semibold text-primary-light"> Téléphone</span>
                                                                    <span class="w-70 text-secondary-light fw-medium">: ***</span>
                                                                </li>
                                                                <li class="d-flex align-items-center gap-1 mb-12">
                                                                    <span class="w-30 text-md fw-semibold text-primary-light"> Addresse</span>
                                                                    <span class="w-70 text-secondary-light fw-medium">: ***</span>
                                                                </li>
                                                            </ul> --}}
                                                        </div>
                                                        <h5>Produits achetés :</h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Quantité</th>
                                                                    <th>Prix Unitaire</th>
                                                                    <th>Sous-total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($sale->products as $product)
                                                                    <tr>
                                                                        <td>{{ $product->name }}</td>
                                                                        <td>{{ $product->pivot->quantity }}</td>
                                                                        <td>{{ number_format($product->price, 2) }} fcfa</td>
                                                                        <td>{{ number_format($product->pivot->subtotal, 2) }} fcfa</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                
                                        <form action="{{ route('update-sale', $sale->id) }}" method="POST" class="tab-pane fade" id="pills-change-passwork" role="tabpanel" aria-labelledby="pills-change-passwork-tab" tabindex="0">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body">
                                                <div class="row gy-3 needs-validation align-items-end">
                                                    <div class="col-md-4">
                                                        <label for="client" class="form-label fw-semibold text-primary-light text-sm mb-8">Client </label>
                                                        <select class="form-control radius-8 form-select" id="client" name="client" required>
                                                            <option value="">Sélectionner un client</option>
                                                            <option value="">Autre</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}" {{ $sale->client_id == $client->id ? 'selected' : '' }}>
                                                                    {{ $client->lastname }} {{ $client->firstname }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="product" class="form-label fw-semibold text-primary-light text-sm mb-8">Produit<span class="text-danger-600">*</span> </label>
                                                        <select class="form-control radius-8 form-select" id="product" name="product">
                                                            <option value="">Sélectionner un produit</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                                    {{ $product->name }}
                                                                </option>
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
                                                                        @foreach ($sale->products as $product)
                                                                            <tr>
                                                                                <td>{{ $product->name }}</td>
                                                                                <td><input type="number" class="product-quantity" value="{{ $product->pivot->quantity }}"></td>
                                                                                <td>{{ $product->price }}</td>
                                                                                <td class="product-total">{{ $product->pivot->total }}</td>
                                                                                <td><button type="button" class="btn btn-danger btn-sm delete">X</button></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <!-- Total Général -->
                                                                <h4>Total: <span id="totalGeneral">{{ number_format($sale->total, 2) }}</span> FCFA</h4>
                            
                                                                <!-- Champ caché pour envoyer les données des produits -->
                                                                <input type="hidden" name="products" id="productsJson">
                            
                                                                <button type="submit" class="btn btn-success">Modifier la Vente</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>






            <!-- Importation de jQuery -->
            <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

            <script>
                $(document).ready(function () {
                    let products = @json($sale->products->map(fn($p) => ['product' => $p->id, 'quantity' => $p->pivot->quantity, 'total' => $p->pivot->total]));

                    function updateTotal() {
                        let total = products.reduce((sum, p) => sum + p.total, 0);
                        $("#totalGeneral").text(total);
                    }
            
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
                        let row = `<tr>
                            <td>${productName}</td>
                            <td><input type="number" class="product-quantity" value="${quantity}"></td>
                            <td>${price}</td>
                            <td class="product-total">${total}</td>
                            <td><button type="button" class="delete">X</button></td>
                        </tr>`;
                        $("#productList").append(row);

                        products.push({ product: productId, quantity: quantity, total: total });
                        $("#productsJson").val(JSON.stringify(products));
                        updateTotal();
                    });

                    $(document).on("click", ".delete", function () {
                        let index = $(this).closest("tr").index();
                        products.splice(index, 1);
                        $(this).closest("tr").remove();
                        $("#productsJson").val(JSON.stringify(products));
                        updateTotal();
                    });

                    $(document).on("change", ".product-quantity", function () {
                        let index = $(this).closest("tr").index();
                        let newQuantity = parseInt($(this).val());
                        products[index].quantity = newQuantity;
                        products[index].total = products[index].quantity * products[index].total;
                        $(this).closest("tr").find(".product-total").text(products[index].total);
                        $("#productsJson").val(JSON.stringify(products));
                        updateTotal();
                    });
                });
            </script>

@endsection

