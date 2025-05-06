@extends('layouts.guest')

@section('title', 'Vérification de l\'adresse email')
@section('description', 'Vérifiez votre adresse email pour activer votre compte OctoPOS.')

@push('styles')
<style>
    .email-verify-card {
        max-width: 550px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="email-verify-card bg-white rounded-2xl overflow-hidden shadow-xl mb-8">
    <!-- Card Header -->
    <div class="bg-gradient-to-r from-[#0288D1] to-[#026da8] px-6 sm:px-8 py-5 sm:py-6 text-white">
        <h1 class="text-xl sm:text-2xl font-bold mb-1">Vérification de l'email</h1>
        <p class="text-white/80 text-sm sm:text-base">Veuillez vérifier votre adresse email</p>
    </div>

    <!-- Card Body -->
    <div class="p-6 sm:p-8">
        @if (session('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-6">
            <div class="flex items-start">
                <div class="mt-0.5 text-blue-500"><i class="fas fa-info-circle text-lg"></i></div>
                <div class="ml-3 text-sm text-blue-700">
                    <h4 class="font-semibold mb-1">Vérification nécessaire</h4>
                    <p>Avant de continuer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, cliquez sur le bouton ci-dessous pour en recevoir un nouveau.</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <div class="mb-6">
                <i class="fas fa-envelope-open-text text-5xl text-[#0288D1]"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Un email de vérification a été envoyé à</h2>
            <p class="text-gray-800 font-medium text-xl mb-6">{{ session('registered_email') ?: auth()->user()->email }}</p>
        </div>

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                @csrf
                <button type="submit" class="bg-gradient-to-r from-[#0288D1] to-[#4CAF50] hover:from-[#026da8] hover:to-[#3d8b40] text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center font-semibold shadow-lg hover:shadow-xl mx-auto">
                    <i class="fas fa-paper-plane mr-2"></i> Renvoyer l'email de vérification
                </button>
            </form>

            <div class="text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-gray-800 text-sm transition duration-300">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection