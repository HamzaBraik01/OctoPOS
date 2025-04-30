{{-- resources/views/gerants/dashboard.blade.php --}}
@extends('layouts.gerant')

@section('title', 'OctoPOS Dashboard | Gérant - Supervision') {{-- Titre spécifique --}}

@section('content')

    {{-- Bannière Mode Crise (Affichée/Masquée par JS) --}}
    <div id="crisis-banner" class="hidden m-6 p-4 bg-red-500 bg-opacity-10 dark:bg-red-900 dark:bg-opacity-30 border border-red-500 rounded-lg">
        <div class="flex items-center">
            <div class="mr-4 bg-red-500 rounded-full p-2">
                <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
            <div>
                <h3 class="font-bold text-red-600 dark:text-red-400">Mode Crise Activé</h3>
                <p class="text-red-700 dark:text-red-300">Gestion prioritaire des ressources et du personnel. Les alertes vocales sont activées.</p>
            </div>
            <button id="alert-speak-button" class="ml-auto bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition">
                <i class="fas fa-volume-up"></i>
            </button>
        </div>
    </div>

    {{-- Inclusion des différentes sections --}}
    {{-- Le JS se chargera de masquer/afficher la bonne section --}}
    @include('gerants.sections.reservations')
    @include('gerants.sections.caisse')
    @include('gerants.sections.commandes')
    @include('gerants.sections.tables')
    @include('gerants.sections.personnel')
    @include('gerants.sections.rapports')

@endsection

@push('scripts')
    {{-- Si vous avez besoin de JS spécifique uniquement pour cette page --}}
    {{-- Par exemple, passer des données Laravel initiales au JS --}}
    {{-- <script>
        const initialTableData = @json($tables ?? []); // Exemple
        // ... utiliser initialTableData dans gerant.js
    </script> --}}
@endpush