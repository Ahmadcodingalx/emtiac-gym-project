@extends('layout.layout')
@php
    $title='Liste des abonnements';
    $subTitle = 'Abonnements';
    $script ='<script>
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
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <form class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" id="search" placeholder="Search">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>Tout</option>
                            <option>actif</option>
                            <option>expiré</option>
                            <option>suspendu</option>
                            <option>attente</option>
                        </select>
                    </div>
                    <form action="{{ route('rest-abonnement') }}" method="POST" class="navbar-search">
                        @method('PUT')
                        <input type="text" class="bg-base h-40-px" name="id" id="id" style="width: 200px; padding: 0px 8px;" placeholder="Code de l'abonnement">
                        <input type="number" class="bg-base h-40-px" name="amount" id="amount" style="width: 100px; padding: 0px 8px;" placeholder="Montant">
                        <button type="submit" class="btn btn-primary text-sm mx-10 btn-sm radius-8">Payeé</button>
                    </form>
                    <a  href="{{ route('addAb') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Créer un abonnement
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
                                    <th scope="col">Date de création</th>
                                    {{-- <th scope="col">Client</th> --}}
                                    <th scope="col">Code</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date de debut</th>
                                    <th scope="col">Date de fin</th>
                                    <th scope="col">Montant Payé</th>
                                    <th scope="col">Montant Restant</th>
                                    <th scope="col">À payer avant le </th>
                                    {{-- <th scope="col" class="text-center">Status</th> --}}
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abonnements as $abonnement)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-10">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                                </div>
                                                {{ $abonnement->id }}
                                            </div>
                                        </td>
                                        <td>{{ $abonnement->created_at }}</td>
                                        <td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $abonnement->transaction_id }}</span></td>
                                        <td class="dropdown">
                                            <button class="{{ 
                                                    $abonnement->status == 'expiré' ? 'bg-danger-400' :
                                                    ($abonnement->status == 'suspendu' ? 'bg-neutral-400' :
                                                    ($abonnement->status == 'attente' ? 'bg-warning-400' : 'bg-success-400'))
                                                    }} radius-8 p-3 text-white w-100 not-active py-8" style="text-align: center"  type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $abonnement->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if ($abonnement->status != 'expiré')
                                                    @if ($abonnement->status != 'actif')
                                                        <li><a href="{{ route('update-status', ['id' => $abonnement->id, 'status' => 'actif']) }}" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900"  href="javascript:void(0)">Activer</a></li>
                                                        @if ($abonnement->status != 'suspendu')
                                                            <li><a href="{{ route('update-status', ['id' => $abonnement->id, 'status' => 'suspendu']) }}" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900"  href="javascript:void(0)">Suspendre</a></li>
                                                        @endif
                                                    @endif
                                                @endif
                                                
                                            </ul>
                                        </td>
                                        <td>{{ $abonnement->start_date }}</td>
                                        <td>{{ $abonnement->end_date }}</td>
                                        <td>{{ $abonnement->price ?? $abonnement->type->amount }}</td>
                                        <td>{{ $abonnement->if_all_pay == false ? $abonnement->rest : "0" }} fcfa</td>
                                        <td>{{ $abonnement->if_all_pay == false ? $abonnement->end_pay_date : "---" }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                                    <a href="{{ route('showAb', ['id' => $abonnement->id]) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                    </a>
                                                    <a href="{{ route('showAb', ['id' => $abonnement->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                    </a>
                                                </div>
                                                <form action="{{ route('delete-abonnement') }}" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet abonnement ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value={{ $abonnement->id }}>
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
                        {{-- <div class="pagination-wrapper">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div> --}}
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing 1 to 10 of 12 entries</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"  href="{{ $abonnements->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md bg-primary-600 text-white"  href="?page=1">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px"  href="?page=2">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"  href="?page=3">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"  href="?page=4">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"  href="?page=5">5</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md"  href="{{ $abonnements->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



    <!-- Importation de jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
    
                $.ajax({
                    url: "/fetch-abonnements",
                    type: "GET",
                    data: { search: query },
                    success: function(response) {
                        let abonnements = response.data; // Récupère les abonnements paginés
                        let tbody = $('#abonnement-table tbody');
                        tbody.empty();
    
                        abonnements.forEach(abonnement => {
                            tbody.append(`
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            ${abonnement.id}
                                        </div>
                                    </td>
                                    <td>${abonnement.created_at}</td>
                                    <td><span class="text-md mb-0 fw-normal text-secondary-light">${abonnement.transaction_id}</span></td>
                                    <td class="dropdown">
                                        <button class="${
                                                abonnement.status === 'expiré' ? 'bg-danger-400' :
                                                (abonnement.status === 'suspendu' ? 'bg-neutral-400' :
                                                (abonnement.status === 'attente' ? 'bg-warning-400' : 'bg-success-400'))
                                            } radius-8 p-3 text-white w-100 not-active py-8" style="text-align: center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            ${abonnement.status}
                                        </button>
                                        <ul class="dropdown-menu">
                                            ${abonnement.status !== 'expiré' ? `
                                                ${abonnement.status !== 'actif' ? `
                                                    <li><a href="/update-status/${abonnement.id}/actif" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900">Activer</a></li>
                                                    ${abonnement.status !== 'suspendu' ? `
                                                        <li><a href="/update-status/${abonnement.id}/suspendu" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900">Suspendre</a></li>
                                                    ` : ''}
                                                ` : ''}
                                            ` : ''}
                                        </ul>
                                    </td>
                                    <td>${abonnement.start_date}</td>
                                    <td>${abonnement.end_date}</td>
                                    <td>${abonnement.price ?? abonnement.type.amount}</td>
                                    <td>${abonnement.if_all_pay ? abonnement.if_all_pay : "0"} FCFA</td>
                                    <td>${abonnement.if_all_pay ? abonnement.end_pay_date : "---"}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <a href="/showAb/${abonnement.id}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </a>
                                                <a href="/showAb/${abonnement.id}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>
                                            </div>
                                            <form action="/delete-abonnement" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cet abonnement ?')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="id" value="${abonnement.id}">
                                                <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            });
        });
    </script>

@endsection
