{{-- resources/views/partials/cuisiniers/sidebar.blade.php --}}
<aside id="sidebar" class="bg-white dark:bg-gray-800 fixed h-screen w-64 shadow-md border-r border-gray-200 dark:border-gray-700 z-50 transition-all">
    <div class="p-4 flex flex-col h-full"> {{-- Flex pour pousser déconnexion en bas --}}
        {{-- Logo et Toggle --}}
        <div class="flex items-center mb-8 flex-shrink-0">
            <div class="relative mr-2">
                <i class="fas fa-utensils text-green-500 text-2xl absolute -top-1 -left-1 opacity-30"></i>
                <i class="fas fa-utensils text-blue-500 text-2xl"></i>
            </div>
            <span class="logo-text text-2xl font-bold bg-gradient-to-r from-blue-500 to-green-500 bg-clip-text text-transparent">OctoPOS</span>
            <button id="sidebar-toggle" class="ml-auto text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        {{-- Menu Principal --}}
        <nav class="flex-grow overflow-y-auto"> {{-- Permet le scroll si menu long --}}
            <div class="mb-4">
                <p class="text-xs text-gray-400 uppercase font-medium mb-2 menu-text px-4">Cuisine</p>
                {{-- Liens de Section (utilisent data-section pour le JS) --}}
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-md text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-section="commandes">
                    <i class="fas fa-utensils w-6 text-xl mr-3 text-center"></i>
                    <span class="menu-text">Commandes en attente</span>
                    <span class="bg-primary text-white rounded-full text-xs px-2 py-0.5 ml-auto commandes-count">0</span>
                </a>
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-md text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-section="preparation">
                    <i class="fas fa-fire w-6 text-xl mr-3 text-center"></i>
                    <span class="menu-text">En préparation</span>
                    <span class="bg-warning text-white rounded-full text-xs px-2 py-0.5 ml-auto prep-count">0</span>
                </a>
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-md text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-section="allergies">
                    <i class="fas fa-exclamation-triangle w-6 text-xl mr-3 text-center"></i>
                    <span class="menu-text">Allergies et restrictions</span>
                </a>
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-md text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-section="historique">
                    <i class="fas fa-history w-6 text-xl mr-3 text-center"></i>
                    <span class="menu-text">Historique des commandes</span>
                </a>
            </div>

            
        </nav>

        {{-- Déconnexion (en bas) --}}
        <div class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
            {{-- Lien de déconnexion réel (utilisera une route Laravel) --}}
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="sidebar-link flex items-center py-3 px-4 rounded-md text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                <i class="fas fa-sign-out-alt w-6 text-xl mr-3 text-center"></i>
                <span class="menu-text">Déconnexion</span>
            </a>
             {{-- Formulaire caché pour la déconnexion POST --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</aside>