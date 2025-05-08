{{-- resources/views/cuisiniers/dashboard.blade.php --}}
@extends('layouts.cuisinier')

@section('title', 'OctoPOS Dashboard | Cuisine - Préparation') {{-- Titre spécifique --}}

@section('content')
    {{-- Inclusion des différentes sections --}}
    {{-- Le JS se chargera de masquer/afficher la bonne section --}}
    @include('cuisiniers.sections.commandes')
    @include('cuisiniers.sections.preparation')
    @include('cuisiniers.sections.historique')

@endsection

@push('scripts')
    {{-- Si vous avez besoin de JS spécifique uniquement pour cette page --}}
    {{-- Par exemple, passer des données Laravel initiales au JS --}}
    {{-- <script>
        const initialCommandesData = @json($commandes ?? []); // Exemple
        // ... utiliser initialCommandesData dans cuisinier.js
    </script> --}}
@endpush