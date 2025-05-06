{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Important for POST forms --}}
    <meta name="description" content="@yield('description', 'OctoPOS - Système de Point de Vente pour Restaurants')">

    <title>@yield('title') - {{ config('app.name', 'OctoPOS') }}</title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Scripts & Styles (Using Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page specific styles --}}
    @stack('styles')

</head>
<body class="font-poppins bg-gray-800 antialiased">
    <!-- Animated Particles Background -->
    <div class="particles"></div>

    <!-- Bouton Retour - Position fixe en haut à gauche, exactement comme dans login.blade.php -->
    <a href="{{ url('/') }}" class="back-link">
        <i class="fas fa-chevron-left mr-2"></i> Retour
    </a>

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 relative z-10">
        <!-- Logo Centré - Exactement comme dans login.blade.php -->
        <div class="w-full max-w-md flex justify-center items-center mb-8">
            <a href="{{ url('/') }}" class="logo-container flex items-center" aria-label="OctoPOS Home">
                <div class="relative mr-2">
                    <i class="fas fa-utensils text-[#4CAF50] text-3xl sm:text-4xl absolute -top-1 -left-1 opacity-30"></i>
                    <i class="fas fa-utensils text-[#0288D1] text-3xl sm:text-4xl"></i>
                </div>
                <span class="logo-text text-3xl sm:text-4xl">OctoPOS</span>
            </a>
        </div>

        {{-- Main Content Area --}}
        @yield('content')

        <!-- Footer -->
        <div class="mt-auto pt-4 text-center text-sm text-white/60 w-full px-4">
            <p>© {{ date('Y') }} OctoPOS. Tous droits réservés.</p>
            <div class="mt-2 flex flex-wrap justify-center gap-2 sm:gap-4">
                {{-- Replace # with actual policy links --}}
                <a href="#" class="text-white/60 hover:text-white transition duration-300">Conditions d'utilisation</a>
                <a href="#" class="text-white/60 hover:text-white transition duration-300">Politique de confidentialité</a>
            </div>
        </div>
    </div>

    {{-- Page specific scripts --}}
    @stack('scripts')
</body>
</html>