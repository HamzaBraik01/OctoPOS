{{-- resources/views/gerants/dashboard.blade.php --}}
@extends('layouts.gerant')

@section('title', 'OctoPOS Dashboard | Gérant - Supervision') {{-- Titre spécifique --}}

@section('content')
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