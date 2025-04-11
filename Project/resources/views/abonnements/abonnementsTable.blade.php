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
                    <td>{{ $abonnement->price ?? $abonnement->type->amount }} fcfa </td>
                    <td>{{ $abonnement->if_all_pay == false ? $abonnement->rest : "0" }} fcfa </td>
                    <td>{{ $abonnement->if_all_pay == false ? $abonnement->end_pay_date : "---" }}</td>
                    <td class="text-center">
                        <div class="d-flex align-items-center gap-10 justify-content-center">
                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                <a href="{{ route('showAb', ['id' => $abonnement->id]) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                </a>
                                <a href="{{ route('recu.preview', $abonnement->id) }}" target="_blank" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="material-symbols-light:print-outline-rounded" width="24" height="24" class="menu-icone"></iconify-icon>
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
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
    <span>Showing {{ $abonnements->firstItem() }} to {{ $abonnements->lastItem() }} of {{ $abonnements->total() }} entries</span>
    
    <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
        <!-- Bouton Précédent -->
        @if ($abonnements->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $abonnements->previousPageUrl() }}">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </a>
            </li>
        @endif

        <!-- Numéros de pages -->
        @foreach ($abonnements->getUrlRange(1, $abonnements->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $abonnements->currentPage() ? 'active' : '' }}">
                <a class="page-link {{ $page == $abonnements->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <!-- Bouton Suivant -->
        @if ($abonnements->hasMorePages())
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $abonnements->nextPageUrl() }}">
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