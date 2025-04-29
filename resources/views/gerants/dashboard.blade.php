@extends('layouts.gerant')

{{-- Vous pouvez définir un titre spécifique pour cette page --}}
@section('title', 'Tableau de bord Gérant - OctoPOS')

@section('content')
    {{-- Inclure toutes les sections. Le JS gérera leur affichage/masquage --}}
    @include('gerants.reservations')
    @include('gerants.caisse')
    @include('gerants.commandes')
    @include('gerants.personnel')
    @include('gerants.rapports')
@endsection