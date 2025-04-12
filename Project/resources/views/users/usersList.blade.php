@extends('layout.layout')
@php
    $title='Liste des utilisateurs';
    $subTitle = 'Utilisateurs';
    // $script ='<script>
    //                     $(".remove-item-btn").on("click", function() {
    //                         $(this).closest("tr").addClass("d-none")
    //                     });
    //         </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
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
                            <input type="text" class="bg-base h-40-px w-auto" name="search" id="search" placeholder="Rechercher">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                    </div>
                    <a  href="{{ route('addUser') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Ajouter un utilisateur
                    </a>
                </div>
                <div class="card-body p-24" id="usersTable">
                    @include('users.userTable', ['users' => $users])
                </div>
            </div>

    
        <!-- Importation de jQuery -->
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

  
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('search');
        
                input.addEventListener('keyup', function () {
                    const query = input.value;
                    console.log(query);
                    if (query == '') {
                        fetch(`{{ route('users.search.zero', ['type' => 0]) }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('usersTable').innerHTML = html;
                            })
                            .catch(error => console.error('Erreur AJAX :', error));
                    } else {
                        fetch(`{{ route('users.search', ['type' => 0]) }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('usersTable').innerHTML = html;
                            })
                            .catch(error => console.error('Erreur AJAX :', error));
                    }
                    
        
                });
            });
        </script>

@endsection
