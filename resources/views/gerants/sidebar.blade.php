{{-- resources/views/partials/gerants/sidebar.blade.php --}}
<aside class="sidebar" id="sidebar">
    <div class="p-4 flex flex-col h-full"> {{-- flex flex-col h-full pour pousser le footer vers le bas --}}
        <div class="mb-8">
            <div class="flex items-center mb-8">
                <a href="{{ route('gerant.dashboard') }}" class="flex items-center group"> {{-- Lien vers le dashboard --}}
                    <div class="relative mr-2">
                        <i class="fas fa-utensils text-[#4CAF50] text-2xl absolute -top-1 -left-1 opacity-30 group-hover:animate-pulse"></i>
                        <i class="fas fa-utensils text-[#0288D1] text-2xl"></i>
                    </div>
                    <span class="logo-text text-2xl font-bold bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">OctoPOS</span>
                </a>
                <button id="sidebar-toggle" class="ml-auto text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none" aria-label="Toggle Sidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
        </div>

        <nav class="flex-grow"> {{-- flex-grow pour occuper l'espace disponible --}}
            <div class="mb-6">
                <p class="text-xs text-gray-400 uppercase font-medium mb-2 menu-text px-4">Opérations</p>
                {{-- Le href="#" est remplacé par data-section pour le JS, mais pourrait être une vraie route si chaque section est une page distincte --}}
                <a href="#reservations" class="sidebar-link" data-section="reservations">
                    <i class="fas fa-calendar-check fa-fw"></i> {{-- fa-fw pour largeur fixe --}}
                    <span class="menu-text">Réservations</span>
                    {{-- Le compteur peut être dynamique --}}
                    <span class="ml-auto bg-primary text-white text-xs font-semibold py-0.5 px-2 rounded-full">4</span>
                </a>
                <a href="#caisse" class="sidebar-link" data-section="caisse">
                    <i class="fas fa-cash-register fa-fw"></i>
                    <span class="menu-text">Caisse & Paiements</span>
                </a>
                <a href="#commandes" class="sidebar-link" data-section="commandes">
                    <i class="fas fa-utensils fa-fw"></i>
                    <span class="menu-text">Commandes</span>
                </a>
            </div>

            <div class="mb-4">
                <p class="text-xs text-gray-400 uppercase font-medium mb-2 menu-text px-4">Gestion</p>
                <a href="#personnel" class="sidebar-link" data-section="personnel">
                    <i class="fas fa-users fa-fw"></i>
                    <span class="menu-text">Personnel</span>
                </a>
                <a href="#rapports" class="sidebar-link" data-section="rapports">
                    <i class="fas fa-chart-bar fa-fw"></i>
                    <span class="menu-text">Rapports</span>
                </a>
            </div>
        </nav>

        <div class="mt-auto pt-8 border-t border-gray-200 dark:border-gray-700"> {{-- mt-auto pousse cet élément vers le bas --}}
             {{-- Exemple de lien de déconnexion utilisant le système d'authentification de Laravel --}}
            <form method="POST" action="{{ route('logout') }}" class="block">
                 @csrf
                 <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="sidebar-link text-red-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:text-red-400 dark:hover:text-red-300">
                     <i class="fas fa-sign-out-alt fa-fw"></i>
                     <span class="menu-text">Déconnexion</span>
                 </a>
             </form>
            {{-- Lien simple si vous n'utilisez pas l'auth Laravel standard --}}
            {{-- <a href="/logout" class="sidebar-link text-red-500 hover:bg-red-50 hover:text-red-600">
                <i class="fas fa-sign-out-alt fa-fw"></i>
                <span class="menu-text">Déconnexion</span>
            </a> --}}
        </div>
    </div>
</aside>