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
            {{-- Nom du restaurant (dynamique ?) --}}
            <span class="ml-3 text-xs bg-blue-100 text-blue-800 font-medium py-1 px-2 rounded dark:bg-blue-900 dark:text-blue-200">Le Bistro Parisien</span>
        </div>

        {{-- Actions Droite --}}
        <div class="flex items-center space-x-2 sm:space-x-4">
            {{-- Crisis Mode Toggle --}}
            {{-- Assurez-vous que l'ID est présent pour le JS --}}
             <div id="crisis-toggle-button" class="crisis-toggle-button" title="Activer/Désactiver Mode Crise">
                 <span class="sr-only">Mode Crise</span>
             </div>

            {{-- Theme Toggle --}}
            <div id="theme-toggle" class="theme-toggle mx-2">
                <span class="sr-only">Basculer le thème jour/nuit</span>
            </div>

            {{-- Date/Heure --}}
            <div class="hidden md:block text-sm text-gray-600 dark:text-gray-300">
                <span id="current-date-time">Chargement...</span> {{-- Le JS mettra à jour --}}
            </div>

            <div class="border-l border-gray-300 dark:border-gray-700 h-6 mx-2 hidden md:block"></div>

            {{-- Infos Utilisateur (Dynamique avec Auth::user()) --}}
            @auth {{-- Vérifie si l'utilisateur est connecté --}}
            <div class="flex items-center">
                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold mr-2 uppercase">
                    {{-- Initiales de l'utilisateur --}}
                    {{ substr(Auth::user()->name, 0, 1) }}{{-- Première lettre du nom --}}
                    {{-- Vous pouvez améliorer pour avoir 2 initiales si nom composé --}}
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