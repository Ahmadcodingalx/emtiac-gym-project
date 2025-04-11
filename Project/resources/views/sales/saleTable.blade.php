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
                <th scope="col">Date de vente</th>
                <th scope="col">Client</th>
                <th scope="col">Somme</th>
                {{-- <th scope="col" class="text-center">Status</th> --}}
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-10">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                            </div>
                            {{ $sale->id }}
                        </div>
                    </td>
                    <td>{{ $sale->created_at }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <img src="{{ asset('storage/' . $sale->client->image) }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden"> --}}
                            <div class="flex-grow-1">
                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $sale->client->lastname ?? "---" }} {{ $sale->client->firstname ?? "---" }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $sale->total }}</span></td>
                    <td class="text-center">
                        <div class="d-flex align-items-center gap-10 justify-content-center">
                            <a href="{{ route('showSale', ['id' => $sale->id]) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                            </a>
                            <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                            </button>
                            <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
    <span>Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} entries</span>
    
    <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
        <!-- Bouton Précédent -->
        @if ($sales->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $sales->previousPageUrl() }}">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </a>
            </li>
        @endif

        <!-- Numéros de pages -->
        @foreach ($sales->getUrlRange(1, $sales->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $sales->currentPage() ? 'active' : '' }}">
                <a class="page-link {{ $page == $sales->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <!-- Bouton Suivant -->
        @if ($sales->hasMorePages())
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $sales->nextPageUrl() }}">
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