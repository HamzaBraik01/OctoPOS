{{-- resources/views/partials/gerants/header.blade.php --}}
<header class="dashboard-header" id="header">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            {{-- Bouton pour ouvrir/fermer la sidebar sur mobile --}}
            <button id="mobile-menu-toggle" class="mr-4 text-gray-500 dark:text-gray-400 md:hidden focus:outline-none" aria-label="Toggle Mobile Menu"> {{-- md:hidden le cache sur les grands écrans --}}
                <i class="fas fa-bars text-xl"></i>
            </button>
            {{-- Le titre pourrait être dynamique basé sur la section affichée --}}
            <h1 class="text-lg font-semibold text-primary">Supervision Opérationnelle</h1>
            {{-- Nom du restaurant dynamique --}}
            <span class="ml-3 text-xs bg-blue-100 text-blue-800 font-medium py-1 px-2 rounded dark:bg-blue-900 dark:text-blue-300">{{ $restaurantName ?? 'Le Bistro Parisien' }}</span>
        </div>

        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Live Counter -->
            <div class="hidden md:flex items-center text-sm px-3 py-1 bg-success/10 text-success rounded-full">
                <div class="w-2 h-2 rounded-full bg-success mr-2 animate-ping absolute"></div>
                <div class="w-2 h-2 rounded-full bg-success mr-2 relative"></div>
                {{-- Donnée dynamique --}}
                <span id="live-clients-counter">24 clients présents</span>
            </div>

            <!-- Crisis Toggle -->
            <div class="crisis-toggle">
                <span class="crisis-toggle-label text-sm font-medium mr-2 hidden lg:inline">Mode Crise</span>
                <button id="crisis-toggle-button" class="crisis-toggle-button" aria-label="Toggle Crisis Mode"></button>
            </div>

            <!-- Day/Night toggle -->
            <button id="theme-toggle" class="theme-toggle mx-2 focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-full" aria-label="Basculer le thème jour/nuit">
                {{-- L'apparence est gérée par CSS --}}
            </button>

            <!-- Current time -->
            <div class="hidden lg:block text-sm text-gray-600 dark:text-gray-300 font-mono" title="Heure actuelle">
                <i class="far fa-clock mr-1"></i>
                <span id="current-date-time">Loading...</span>
            </div>

            <div class="border-l border-gray-300 dark:border-gray-700 h-6 mx-1 sm:mx-2"></div>

            <!-- Notifications -->
            <div class="relative">
                <button class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary focus:outline-none" aria-label="Notifications">
                    <i class="fas fa-bell text-xl"></i>
                    {{-- Compteur dynamique --}}
                    <span class="absolute -top-1 -right-1 bg-danger text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full font-bold">5</span>
                </button>
                {{-- Ici pourrait s'ouvrir un dropdown de notifications --}}
            </div>

            <!-- Profile -->
            <div class="relative">
                <button class="flex items-center focus:outline-none" aria-label="User Menu">
                    {{-- Image/Initiales dynamiques --}}
                    @auth {{-- Vérifie si l'utilisateur est connecté --}}
                        <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm mr-2 overflow-hidden">
                            {{-- Afficher une image si disponible, sinon les initiales --}}
                            @if(Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                {{-- Fonction pour obtenir les initiales (à créer dans un Helper ou modèle User) --}}
                                {{-- {{ Auth::user()->initials() }} --}}
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} {{-- Simple initiales --}}
                            @endif
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight">{{ Auth::user()->role ?? 'Gérant' }}</p> {{-- Role dynamique --}}
                        </div>
                    @else
                        {{-- Fallback si non connecté --}}
                         <div class="w-9 h-9 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold text-sm mr-2">?</div>
                    @endauth
                </button>
                 {{-- Ici pourrait s'ouvrir un dropdown de profil (paramètres, déconnexion etc) --}}
            </div>
        </div>
    </div>
</header>