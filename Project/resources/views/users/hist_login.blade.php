@extends('layout.layout')
@php
    $title='Historique des connexions';
    $subTitle = 'Historique';
    $script ='<script>
                        $(".remove-item-btn").on("click", function() {
                            $(this).closest("tr").addClass("d-none")
                        });
            </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <form class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" id="searchInput" placeholder="Rechercher par nom ou par date">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                    </div>
                    {{-- <a  href="{{ route('addAb') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Exporter
                    </a> --}}
                </div>
                <div class="card-body p-24" id="histTable">
                    @include('users.hist_login_table', ['historiques' => $historiques])
                </div>
            </div>



    <!-- Importation de jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('searchInput');
    
            input.addEventListener('keyup', function () {
                const query = input.value;
                console.log(query);
                if (query == '') {
                    fetch(`{{ route('hist_login.search.zero') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('histTable').innerHTML = html;
                        })
                        .catch(error => console.error('Erreur AJAX :', error));
                } else {
                    fetch(`{{ route('hist_login.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('histTable').innerHTML = html;
                        })
                        .catch(error => console.error('Erreur AJAX :', error));
                }
                
    
            });
        });
    </script>

@endsection
