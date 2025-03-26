@extends('layout.layout')
@php
    $title='Liste des Types d\'abonnement';
    $subTitle = 'Types d\'abonnement';
    $script = '<script>
                        $(".delete-btn").on("click", function() {
                            $(this).closest(".user-grid-card").addClass("d-none")
                        });
                </script>';
@endphp

@section('content')

    <div class="row gy-4">
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
        <div class="col-lg-4">

            <div class="">
                <div class="card radius-12">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Ajouter un Type d'abonnement</h6>
                    </div>
                    <form class="card-body" action="{{ route('new-type') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Nom</label>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Entrer le nom du type d'abonnement">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Montant</label>
                                <input type="number" name="amount" class="form-control form-control-lg" placeholder="Entrer le montant">
                            </div>
                            <div class="row gy-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label">Nombre</label>
                                    <input type="number" name="number" id="number" class="form-control" placeholder="Entrer le nombre de jour" value="1" min="1" required>
                                </div>
                                <div class="col-md-auto">
                                    <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Nature du type <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="type" name="type">
                                        <option value="">Choisir</option>
                                        <option value="Jour">Jour</option>
                                        <option value="Semaine">Semaine</option>
                                        <option value="Mois">Mois</option>
                                        <option value="Année">Année</option>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <label class="form-label">Description</label>
                                <textarea name="desc" class="form-control" rows="4" cols="50" placeholder="Enter une description..."></textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                {{-- <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                    Cancel
                                </button> --}}
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                    Créer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">

            <div class="card h-100 p-0 radius-12">
                <div class="card-body p-24">
                    <div class="p-24" style="width: 100%; overflow-x: auto; white-space: nowrap; display: flex; gap: 20px;">
                        @foreach ($types as $type)
                            <div class="col-xxl-3 col-md-6 user-grid-card   ">
                                <div class="position-relative border radius-16 overflow-hidden">
                                    <img src="{{ asset('assets/images/29625.jpg') }}" alt="" class="w-100 object-fit-cover">

                                    <div class="dropdown position-absolute top-0 end-0 me-16 mt-16">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="bg-white-gradient-light w-32-px h-32-px radius-8 border border-light-white d-flex justify-content-center align-items-center text-white">
                                            <iconify-icon icon="entypo:dots-three-vertical" class="icon "></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu p-12 border bg-base shadow">
                                            <li>
                                                <a onclick="toggleInput({{ $type->id }})" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-10"  href="#">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('delete-type') }}" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $type->id }}">
                                                    <button type="submit" class="delete-btn dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-danger-100 text-hover-danger-600 d-flex align-items-center gap-10">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    <form action="{{ route('update-type') }}" method="POST" class="ps-16 pb-16 pe-16 text-center mt--50">
                                        @csrf
                                        @method('PUT')
                                        <img src="{{ asset('assets/images/34563.png') }}" alt="" class="border br-white border-width-2-px w-100-px h-100-px rounded-circle object-fit-cover">
                                        {{-- <h6 class="text-lg mb-0 mt-4">Jacob Jones</h6> --}}
                                        <div class="col-12">
                                            <input value="{{ $type->id }}" type="hidden" name="id">
                                            <input disabled id="myInput1{{ $type->id }}" value="{{ $type->name }}" style="background-color: transparent; border-color: transparent; font-size: 22px; font-weight: bold;" type="text" name="name" class="form-control form-control-lg" placeholder="Entrer le nom du Type d'abonnement">
                                        </div>
                                        <div class="" style="display: flex; align-items: center; justify-content: center;">
                                            <input disabled id="amount{{ $type->id }}" value="{{ $type->amount }}" style="background-color: transparent; border-color: transparent; font-size: 22px; font-weight: bold; width: 100px; padding: 0;" type="number" name="amount" class="form-control form-control-lg" placeholder="Entrer le montant">
                                            <h7 style="position: relative; left: -10px;">fcfa</h7>
                                        </div>
                                        <div class="row gy-3 align-items-end">
                                            <div class="col-md-5">
                                                {{-- <label class="form-label">Nombre</label> --}}
                                                <input disabled type="number" name="number" id="number{{ $type->id }}" value="{{ $type->number }}" class="form-control" placeholder="Entrer le nombre de jour" style="background-color: transparent; border-color: transparent; font-size: 22px; font-weight: bold;" value="1" min="1" required>
                                            </div>
                                            <div class="col-md-auto">
                                                {{-- <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Nature du type <span class="text-danger-600">*</span> </label> --}}
                                                <select disabled class="form-control radius-8 form-select" id="type{{ $type->id }}" value="{{ $type->type }}" name="type" style="background-color: transparent; border-color: transparent; font-size: 22px; font-weight: bold;">
                                                    <option value="{{ $type->id }}"> {{ $type->type }} </option>
                                                    <option value="">Jour</option>
                                                    <option value="">Semaine</option>
                                                    <option value="">Mois</option>
                                                    <option value="">Année</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if ($type->description)
                                            <div class="">
                                                <textarea disabled id="myInput2{{ $type->id }}" style="background-color: transparent; border-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"  name="desc" class="form-control" rows="4" cols="50" placeholder="Enter une description...">{{ $type->description }}</textarea>
                                            </div>
                                        @else
                                            <div class="">
                                                <textarea disabled id="myInput2{{ $type->id }}" style="background-color: transparent; border-color: transparent; resize: none; width: 100%; overflow-x: hidden; white-space: pre-wrap; word-wrap: break-word;"  name="desc" class="form-control" rows="4" cols="50" placeholder="Enter une description...">Pas de description</textarea>
                                            </div>
                                        @endif
                                        <div class="align-items-center justify-content-center gap-5 mt-10" id="myButtons{{ $type->id }}" style="display: none;">
                                            {{-- <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Cancel
                                            </button> --}}
                                            <button type="reset" onclick="toggleReset({{ $type->id }})" class="btn btn-outline-danger-600 radius-8 px-20 py-11">Annuler</button>
                                            <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">Modifier</button>
                                            {{-- <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                Créer
                                            </button> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleInput(id) {
            let input1 = document.getElementById("myInput1" + id);
            let input2 = document.getElementById("myInput2" + id);
            let amount = document.getElementById("amount" + id);
            let number = document.getElementById("number" + id);
            let type = document.getElementById("type" + id);
            input1.disabled = !input1.disabled; // Inverse l'état (activé/désactivé)
            input2.disabled = !input2.disabled; // Inverse l'état (activé/désactivé)
            amount.disabled = !amount.disabled; // Inverse l'état (activé/désactivé)
            number.disabled = !number.disabled; // Inverse l'état (activé/désactivé)
            type.disabled = !type.disabled; // Inverse l'état (activé/désactivé)

            let buttons = document.getElementById("myButtons" + id);

        if (buttons.style.display === "none") {
            buttons.style.display = "flex"; // Affiche l'input
        } else {
            buttons.style.display = "none"; // Masque l'input
        }
        }
        function toggleReset(id) {
            let input1 = document.getElementById("myInput1" + id);
            let input2 = document.getElementById("myInput2" + id);
            let amount = document.getElementById("amount" + id);
            let number = document.getElementById("number" + id);
            let type = document.getElementById("type" + id);
            input1.disabled = !input1.disabled; // Inverse l'état (activé/désactivé)
            input2.disabled = !input2.disabled; // Inverse l'état (activé/désactivé)
            amount.disabled = !amount.disabled; // Inverse l'état (activé/désactivé)
            number.disabled = !number.disabled; // Inverse l'état (activé/désactivé)
            type.disabled = !type.disabled; // Inverse l'état (activé/désactivé)

            let buttons = document.getElementById("myButtons" + id);

        if (buttons.style.display === "none") {
            buttons.style.display = "flex"; // Affiche l'input
        } else {
            buttons.style.display = "none"; // Masque l'input
        }
        }
    </script>

@endsection
