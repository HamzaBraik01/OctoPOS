<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="OctoPOS - Système de point de vente pour serveurs">

    <title>@yield('title', 'OctoPOS')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    @vite(['resources/css/serveur.css', 'resources/js/serveur.js'])

    @stack('styles')
</head>

<body>
<div class="app-container">
    <header class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-utensils" aria-hidden="true"></i>
                <i class="fas fa-utensils" aria-hidden="true"></i>
            </div>
            <div class="logo-text">OctoPOS</div>
        </div>

        <div class="header-right">
            <div class="datetime">Chargement...</div>
            <div class="restaurant-selector">
                <select id="restaurant-select" class="styled-select" aria-label="Sélectionner un restaurant">
                    <option value="" disabled {{ !session('restaurant_id') ? 'selected' : '' }}>Choisir un restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ session('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                            {{ $restaurant->nom }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down select-arrow" aria-hidden="true"></i>
            </div>

            <div class="header-buttons">
                <button id="theme-toggle" class="header-button" aria-label="Basculer le thème sombre/clair">
                    <i class="fas fa-moon"></i>
                </button>
             
              
            </div>

            <div class="user-info">
                <div class="avatar" aria-hidden="true">{{ substr(auth()->user()->frist_name, 0, 1) . substr(auth()->user()->last_name, 0, 1) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->frist_name . ' ' . auth()->user()->last_name }}</div>
                    <div class="user-role">{{ auth()->user()->role }}</div>
                </div>
                <button class="header-button" aria-label="Menu utilisateur">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <a style="text-decoration: none" href="{{ route('logout') }}" class="header-button logout-button" aria-label="Déconnexion" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
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

</div>

@stack('scripts')

</body>
</html>