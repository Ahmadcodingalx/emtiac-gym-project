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
                <th scope="col">Nom et prénom</th>
                <th scope="col">Identifiant</th>
                <th scope="col">Email</th>
                <th scope="col">Téléphone</th>
                {{-- <th scope="col" class="text-center">Status</th> --}}
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-10">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                            </div>
                            {{ $client->id }}
                        </div>
                    </td>
                    <td>{{ $client->created_at }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $client->image) }}" alt="Photo de {{ $client->lastname }}" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $client->lastname }} {{ $client->firstname }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $client->identifiant }}</span></td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->tel }}</td>
                    {{-- <td class="text-center">
                        <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                    </td> --}}
                    <td class="text-center">
                        <div class="d-flex align-items-center gap-10 justify-content-center">
                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                <a href="{{ route('viewClient', ['id' => $client->id]) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                </a>
                                <a href="{{ route('viewClient', ['id' => $client->id]) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                </a>
                            </div>
                            <form action="{{ route('delete-client') }}" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value={{ $client->id }}>
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
    <span>Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} entries</span>
    
    <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
        <!-- Bouton Précédent -->
        @if ($clients->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $clients->previousPageUrl() }}">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </a>
            </li>
        @endif

        <!-- Numéros de pages -->
        @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $clients->currentPage() ? 'active' : '' }}">
                <a class="page-link {{ $page == $clients->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <!-- Bouton Suivant -->
        @if ($clients->hasMorePages())
            <li class="page-item">
                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $clients->nextPageUrl() }}">
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