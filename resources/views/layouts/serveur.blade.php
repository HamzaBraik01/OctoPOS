<<<<<<< HEAD
{{-- resources/views/layouts/serveur.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="OctoPOS - Système de point de vente pour serveurs">

    <title>@yield('title', 'OctoPOS')</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/serveur.css', 'resources/js/serveur.js'])

    @stack('styles')
</head>

<body>
<div class="app-container">
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-utensils" aria-hidden="true"></i> {{-- Icône arrière --}}
                <i class="fas fa-utensils" aria-hidden="true"></i> {{-- Icône avant --}}
            </div>
            <div class="logo-text">OctoPOS</div>
        </div>

        <div class="header-right">
            <div class="datetime">Chargement...</div> {{-- Sera mis à jour par JS --}}

            <div class="header-buttons">
                <button id="theme-toggle" class="header-button" aria-label="Basculer le thème sombre/clair">
                    <i class="fas fa-moon"></i>
                </button>
                <button id="contrast-toggle" class="header-button" aria-label="Basculer le mode contraste élevé">
                    <i class="fas fa-adjust"></i>
                </button>
                <button id="notifications" class="header-button" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    {{-- Le nombre de notifications pourrait être dynamique --}}
                    {{-- @if(auth()->user()->unreadNotifications->count() > 0) --}}
                    {{-- <span class="badge" aria-hidden="true">{{ auth()->user()->unreadNotifications->count() }}</span> --}}
                    {{-- @endif --}}
                    <span class="badge" aria-hidden="true">3</span> {{-- Exemple statique --}}
                </button>
            </div>

            <div class="user-info">
                {{-- Authentification Laravel --}}
                {{-- @auth --}}
                <div class="avatar" aria-hidden="true">{{-- strtoupper(substr(Auth::user()->name, 0, 2)) --}}HB</div>
                <div class="user-details">
                    <div class="user-name">{{-- Auth::user()->name --}}Hamza Br</div>
                    <div class="user-role">{{-- Auth::user()->role->name ?? 'Serveur' --}}Serveur</div>
                </div>
                <button class="header-button" aria-label="Menu utilisateur">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                {{-- @endauth --}}
            </div>
        </div>
    </header>

    @yield('content')

    <nav class="bottom-nav" role="navigation" aria-label="Navigation inférieure">
        <a href="#" class="bottom-nav-item" data-tab="tables" role="tab" aria-selected="true" aria-controls="tables-tab">
            <i class="fas fa-th-large bottom-nav-icon" aria-hidden="true"></i>
            <span class="bottom-nav-label">Tables</span>
        </a>
        <a href="#" class="bottom-nav-item" data-tab="orders" role="tab" aria-selected="false" aria-controls="orders-tab" tabindex="-1">
            <i class="fas fa-utensils bottom-nav-icon" aria-hidden="true"></i>
            <span class="bottom-nav-label">Commande</span>
        </a>
        <a href="#" class="bottom-nav-item" data-tab="payment" role="tab" aria-selected="false" aria-controls="payment-tab" tabindex="-1">
            <i class="fas fa-cash-register bottom-nav-icon" aria-hidden="true"></i>
            <span class="bottom-nav-label">Paiement</span>
        </a>
        <a href="#" class="bottom-nav-item" data-tab="receipt" role="tab" aria-selected="false" aria-controls="receipt-tab" tabindex="-1">
            <i class="fas fa-receipt bottom-nav-icon" aria-hidden="true"></i>
            <span class="bottom-nav-label">Tickets</span>
        </a>
        <a href="#" class="bottom-nav-item" data-tab="stats" role="tab" aria-selected="false" aria-controls="stats-tab" tabindex="-1">
            <div style="position: relative;">
                <i class="fas fa-chart-line bottom-nav-icon" aria-hidden="true"></i>
            </div>
            <span class="bottom-nav-label">Stats</span>
        </a>
    </nav>

    <div class="toast-container" aria-live="assertive" aria-atomic="true">
    </div>

</div> {{-- Fin .app-container --}}

@stack('scripts')

</body>
</html>
=======
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Use Laravel's locale helper --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="OctoPOS - Système de point de vente pour serveurs">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OctoPOS') }} | Interface Serveur</title> {{-- Use app name from config --}}

    <!-- Polices -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> {{-- Added integrity/crossorigin --}}

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Inline Tailwind configuration (from your original HTML)
        tailwind.config = {
            darkMode: 'class', // or 'media'
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#DBEAFE',
                            100: '#BFDBFE',
                            500: '#2563EB', // Blue-600
                            600: '#1D4ED8', // Blue-700
                            700: '#1E40AF', // Blue-800
                        },
                        secondary: {
                            50: '#D1FAE5',
                            100: '#A7F3D0',
                            500: '#10B981', // Emerald-500
                            600: '#059669', // Emerald-600
                            700: '#047857', // Emerald-700
                        },
                        danger: {
                            500: '#EF4444', // Red-500
                            600: '#DC2626', // Red-600
                            700: '#B91C1C', // Red-700
                        },
                        warning: {
                            500: '#F59E0B', // Amber-500
                            600: '#D97706', // Amber-600
                            700: '#B45309', // Amber-700
                        },
                    },
                    animation: {
                        'pulse-danger': 'pulse-danger 1.5s infinite ease-in-out',
                        'blink': 'blink 1.8s infinite ease-in-out',
                    },
                    keyframes: {
                        'pulse-danger': {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(239, 68, 68, 0.6)' }, // Red-500 with opacity
                            '70%': { boxShadow: '0 0 0 8px rgba(239, 68, 68, 0)' },
                        },
                        'blink': {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                            '50%': { opacity: '0.6', transform: 'scale(0.9)' },
                        },
                    },
                },
            },
            /
        }
    </script>

    
    @vite(['resources/css/serveur.css', 'resources/js/serveur.js'])

</head>
<body class="font-sans text-gray-800 bg-gray-50 antialiased touch-manipulation transition-colors duration-200 dark:bg-gray-900 dark:text-gray-100">

    
    @yield('content')

    

</body>
</html>
>>>>>>> b78e058317fce2f187271eca71cd7f410c5ff94d
