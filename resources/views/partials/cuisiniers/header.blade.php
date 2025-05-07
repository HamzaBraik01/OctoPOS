{{-- resources/views/partials/cuisiniers/header.blade.php --}}
<header class="fixed right-0 top-0 left-64 h-16 bg-white dark:bg-gray-900 shadow-sm z-20 flex items-center justify-between px-6 transition-all border-b border-border-color dark:border-gray-700">
    <div class="flex items-center">
        <button id="sidebar-toggle" class="mr-4 text-gray-500 hover:text-primary">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="text-lg font-semibold text-gray-800 dark:text-white">Tableau de bord Cuisine</h1>
        
        <div class="ml-6 relative">
            <div class="restaurant-selector">
                <select id="restaurant-select" class="text-sm px-3 py-1.5 pr-8 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="" disabled {{ !session('restaurant_id') ? 'selected' : '' }}>Sélectionner un restaurant</option>
                    @foreach($restaurants ?? [] as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ session('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                            {{ $restaurant->nom }}
                        </option>
                    @endforeach
                </select>
                <span id="restaurant-selection-hint" class="hidden text-xs ml-2 text-red-500 dark:text-red-400">⚠️ Sélectionnez un restaurant</span>
            </div>
        </div>
    </div>

    <div class="flex items-center">
        <div class="relative mr-4">
            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary relative notification-bell">
                <i class="fas fa-bell"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-danger rounded-full notification-indicator"></span>
            </button>
            <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-border-color dark:border-gray-700 hidden notification-dropdown z-50">
                <div class="p-3 border-b border-border-color dark:border-gray-700">
                    <h3 class="text-sm font-semibold">Notifications</h3>
                </div>
                <div class="max-h-60 overflow-y-auto">
                    <div class="p-4 border-b border-border-color dark:border-gray-700">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-warning bg-opacity-20 flex items-center justify-center text-warning">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Nouvelle commande reçue</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Table 12 - 3 plats</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Il y a 2 minutes</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-b border-border-color dark:border-gray-700">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-danger bg-opacity-20 flex items-center justify-center text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Alerte stock</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Stock bas: Champignons</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Il y a 25 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 border-t border-border-color dark:border-gray-700">
                    <a href="#" class="block text-center text-xs text-primary hover:underline">Voir toutes les notifications</a>
                </div>
            </div>
        </div>

        <div class="relative mr-4">
            <button id="theme-toggle" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary">
                <i class="fas fa-sun mode-light"></i>
                <i class="fas fa-moon mode-dark hidden"></i>
            </button>
        </div>

        <div class="relative">
            <button class="flex items-center space-x-2 user-menu-toggle">
                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </span>
                <span class="text-sm font-medium hidden sm:block">{{ Auth::user()->name ?? 'Chef Cuisinier' }}</span>
                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-border-color dark:border-gray-700 hidden user-menu z-50">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-user mr-2"></i> Mon profil
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-cog mr-2"></i> Paramètres
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>