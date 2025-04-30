{{-- resources/views/partials/gerants/header.blade.php --}}
<header id="header" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 fixed right-0 top-0 z-40 py-3 px-6 w-[calc(100%-16rem)] transition-all">
    <div class="flex items-center justify-between">
        {{-- Titre et Menu Mobile Toggle --}}
        <div class="flex items-center">
            <button id="mobile-menu-toggle" class="mr-4 text-gray-500 dark:text-gray-300 lg:hidden"> {{-- Caché sur grand écran --}}
                <i class="fas fa-bars"></i>
            </button>
            {{-- Le titre pourrait être dynamique via @yield ou une variable --}}
            <h1 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Supervision Opérationnelle</h1>
            
            {{-- Restaurant Selector (déplacé ici) --}}
            <div class="ml-4">
                <select id="header-restaurant-selector" class="text-sm px-3 py-1.5 pr-8 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Sélectionner un restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ isset($selectedRestaurantId) && $selectedRestaurantId == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->nom }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="flex items-center space-x-2 sm:space-x-4">
            
            {{-- Theme Toggle --}}
            <div id="theme-toggle" class="theme-toggle mx-2">
                <span class="sr-only">Basculer le thème jour/nuit</span>
            </div>

            {{-- Date/Heure --}}
            <div id="current-date-time" class="text-sm text-gray-600 dark:text-gray-300 hidden sm:block"></div>

            {{-- Profil --}}
            @auth
            <div class="flex items-center ml-4 relative">
                <div class="w-9 h-9 rounded-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-user"></i>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gérant</p> {{-- Rôle dynamique ? --}}
                </div>
            </div>
            @endauth
        </div>
    </div>
</header>

{{-- Template pour les réservations (utilisé par JS) --}}
<template id="reservation-item-template">
    <div class="reservation-item p-3 hover:bg-gray-50 dark:hover:bg-gray-700/30">
        <div class="flex justify-between items-start">
            <div>
                <div class="font-medium text-gray-800 dark:text-gray-200">
                    <span class="reservation-time"></span> - <span class="reservation-client"></span>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="reservation-table"></span> • <span class="reservation-persons"></span> pers.
                </div>
            </div>
            <div class="reservation-status"></div>
        </div>
        <div class="mt-2 flex space-x-1">
            <button class="reservation-arrive p-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Marquer Arrivé">
                <i class="fas fa-check"></i>
            </button>
            <button class="reservation-cancel p-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Annuler">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</template>