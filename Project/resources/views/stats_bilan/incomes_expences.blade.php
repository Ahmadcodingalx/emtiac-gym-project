@extends('layout.layout')
@php
    $title='Entrée / sorties';
    $subTitle = 'Entrée / sorties';
    $script = '<script>
                    $(".remove-item-btn").on("click", function() {
                        $(this).closest("tr").addClass("d-none")
                    });
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
                    <button class="nav-link d-flex align-items-center px-24 active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">
                        Entrée et sorties
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24" id="pills-abb-tab" data-bs-toggle="pill" data-bs-target="#pills-abb" type="button" role="tab" aria-controls="pills-abb" aria-selected="false" tabindex="-1">
                        Abonnements
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24" id="pills-sall-tab" data-bs-toggle="pill" data-bs-target="#pills-sall" type="button" role="tab" aria-controls="pills-sall" aria-selected="false" tabindex="-1">
                        Ventes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center px-24" id="pills-rest-tab" data-bs-toggle="pill" data-bs-target="#pills-rest" type="button" role="tab" aria-controls="pills-rest" aria-selected="false" tabindex="-1">
                        Restes à payés
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <form class="navbar-search" method="GET" action="{{ route('transList') }}">
                                <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" value="{{ request('search') }}">
                                <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                            </form>
                        
                            <form method="GET" action="{{ route('transList') }}">
                                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="type" onchange="this.form.submit()">
                                    <option value="">Tout</option>
                                    <option value="Entrées" {{ request('type') == 'Entrées' ? 'selected' : '' }}>Entrées</option>
                                    <option value="Sorties" {{ request('type') == 'Sorties' ? 'selected' : '' }}>Sorties</option>
                                </select>
                            </form>
                        </div>
                        <a href="{{ route('addTrans') }}" type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                            Effectuer une transaction
                        </a>
                    </div>

                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="d-flex align-items-center gap-10">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                                </div>
                                                S.L
                                            </div>
                                        </th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Utilisateur</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Type </th>
                                        <th scope="col">Nature</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $transaction->lastname ?? 'N/A' }} {{ $transaction->firstname ?? 'N/A' }}</td>
                                            <td class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                                {{ number_format($transaction->amount, 2) }} F
                                            </td>
                                            <td>{{ $transaction->reason }}</td>
                                            <td>
                                                <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $transaction->type === 'income' ? 'Entrée' : 'Sortie' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                                    {{-- @if (!$transaction->abb_id || !$transaction->sale_id) --}}
                                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                                            <a href="{{ route('showAb', ['id' => $transaction->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                            </a>
                                                        </div>
                                                    {{-- @endif --}}
                                                    <form action="" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet transaction ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value={{ $transaction->id }}>
                                                        <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                            <span>Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries</span>
                            
                            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                <!-- Bouton Précédent -->
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->previousPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </a>
                                    </li>
                                @endif
                        
                                <!-- Numéros de pages -->
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link {{ $page == $transactions->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                <!-- Bouton Suivant -->
                                @if ($transactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->nextPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pills-abb" role="tabpanel" aria-labelledby="pills-abb-tab" tabindex="0">
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="d-flex align-items-center gap-10">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                                </div>
                                                S.L
                                            </div>
                                        </th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Utilisateur</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abb as $abonnment)
                                        <tr>
                                            <td>{{ $abonnment->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($abonnment->date)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $abonnment->user->lastname ?? 'N/A' }} {{ $abonnment->user->firstname ?? 'N/A' }}</td>
                                            <td>{{ $abonnment->amount ?? 'N/A' }} fcfa</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                                    {{-- @if (!$transaction->abb_id || !$transaction->sale_id) --}}
                                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                                            <a href="{{ route('showAb', ['id' => $abonnment->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                            </a>
                                                        </div>
                                                    {{-- @endif --}}
                                                    <form action="" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet transaction ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value={{ $abonnment->id }}>
                                                        <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                            <span>Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries</span>
                            
                            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                <!-- Bouton Précédent -->
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->previousPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </a>
                                    </li>
                                @endif
                        
                                <!-- Numéros de pages -->
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link {{ $page == $transactions->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                <!-- Bouton Suivant -->
                                @if ($transactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->nextPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pills-sall" role="tabpanel" aria-labelledby="pills-sall-tab" tabindex="0">
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="d-flex align-items-center gap-10">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                                </div>
                                                S.L
                                            </div>
                                        </th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Utilisateur</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $sale->user->lastname ?? 'N/A' }} {{ $sale->user->firstname ?? 'N/A' }}</td>
                                            <td>{{ $sale->amount ?? 'N/A' }} fcfa</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                                    {{-- @if (!$transaction->abb_id || !$transaction->sale_id) --}}
                                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                                            <a href="{{ route('showAb', ['id' => $sale->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                            </a>
                                                        </div>
                                                    {{-- @endif --}}
                                                    <form action="" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet transaction ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value={{ $sale->id }}>
                                                        <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                            <span>Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries</span>
                            
                            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                <!-- Bouton Précédent -->
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->previousPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </a>
                                    </li>
                                @endif
                        
                                <!-- Numéros de pages -->
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link {{ $page == $transactions->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                <!-- Bouton Suivant -->
                                @if ($transactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->nextPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pills-rest" role="tabpanel" aria-labelledby="pills-rest-tab" tabindex="0">
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="d-flex align-items-center gap-10">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                                </div>
                                                S.L
                                            </div>
                                        </th>
                                        <th scope="col">Date limite</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Montant restant</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rests as $rest)
                                        <tr>
                                            <td>{{ $rest->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rest->end_pay_date)->format('d/m/Y') }}</td>
                                            <td>{{ $rest->client->lastname ?? $rest->lastname ?? 'Autre' }} {{ $rest->client->firstname ?? $rest->lastname ?? '' }}</td>
                                            <td>{{ $rest->rest ?? 'N/A' }} fcfa</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                                    {{-- @if (!$transaction->abb_id || !$transaction->sale_id) --}}
                                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                                            <a href="{{ route('showAb', ['id' => $rest->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                            </a>
                                                        </div>
                                                    {{-- @endif --}}
                                                    <form action="" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet transaction ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value={{ $rest->id }}>
                                                        <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                            <span>Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries</span>
                            
                            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                <!-- Bouton Précédent -->
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->previousPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                                        </a>
                                    </li>
                                @endif
                        
                                <!-- Numéros de pages -->
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link {{ $page == $transactions->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                        
                                <!-- Bouton Suivant -->
                                @if ($transactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $transactions->nextPageUrl() }}">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                                            <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nouvelle transaction</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="{{ route('new-transaction') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Montant </label>
                                <input type="number" name="amount" class="form-control radius-8" placeholder="Entrer le montant">
                            </div>
                            <div class="col-12 mb-20">
                                <label for="nature"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Nature </label>
                                <select class="form-control radius-8 form-select" id="nature" name="nature">
                                    <option value="">Selectionner </option>
                                    <option value="purchase">Achat </option>
                                    <option value="salary">Salaire </option>
                                    <option value="invoice">Facture </option>
                                    <option value="refund">Remboursement </option>
                                    <option value="other">Autre </option>
                                </select>
                            </div>
                            <div class="col-12 mb-20">
                                <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">Date </label>
                                <input type="datetime-local" name="date" id="date" class="form-control radius-8">
                            </div>
                            <div class="col-12 mb-20">
                                <label for="desc" class="form-label fw-semibold text-primary-light text-sm mb-8">Description </label>
                                <textarea class="form-control" id="desc" rows="4" cols="50" name="desc" placeholder="Entrer une description"></textarea>
                            </div>

                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type </label>
                                <div class="d-flex align-items-center flex-wrap gap-28">
                                    <div class="form-check checked-success d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="transaction" id="income" value="income">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light text-sm d-flex align-items-center gap-1" for="income">
                                            <span class="w-8-px h-8-px bg-success-600 rounded-circle"></span>
                                            Entrée
                                        </label>
                                    </div>
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="transaction" id="expense" value="expense">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light text-sm d-flex align-items-center gap-1" for="expense">
                                            <span class="w-8-px h-8-px bg-danger-600 rounded-circle"></span>
                                            Sortie
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8">
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    

@endsection