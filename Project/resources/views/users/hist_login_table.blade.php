<div class="table-responsive scroll-sm">
    <table class="table bordered-table sm-table mb-0">
        <thead>
            <tr>
                <th scope="col">Date de connexion</th>
                <th scope="col">Utilisateur</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historiques as $hist)
                <tr>
                    <td>{{ $hist->created_at }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $hist->user->image ?? "") }}" alt="Photo de {{ $hist->user->lastname }}" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $hist->user->lastname }} {{ $hist->user->firstname }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
    <span>Showing {{ $historiques->firstItem() }} to {{ $historiques->lastItem() }} of {{ $historiques->total() }} entries</span>
    
    <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
        <!-- Bouton Précédent -->
        @if ($historiques->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $historiques->previousPageUrl() }}">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </a>
            </li>
        @endif

        <!-- Numéros de pages -->
        @foreach ($historiques->getUrlRange(1, $historiques->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $historiques->currentPage() ? 'active' : '' }}">
                <a class="page-link {{ $page == $historiques->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <!-- Bouton Suivant -->
        @if ($historiques->hasMorePages())
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $historiques->nextPageUrl() }}">
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