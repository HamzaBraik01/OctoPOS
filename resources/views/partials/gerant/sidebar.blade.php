<aside class="sidebar" id="sidebar">
    <div class="p-4">
        <div class="flex items-center mb-8">
            <div class="relative mr-2">
                <i class="fas fa-utensils text-[#4CAF50] text-2xl absolute -top-1 -left-1 opacity-30"></i>
                <i class="fas fa-utensils text-[#0288D1] text-2xl"></i>
            </div>
            <span class="logo-text text-2xl font-bold bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">OctoPOS</span>
            <button id="sidebar-toggle" class="ml-auto text-gray-400 hover:text-gray-600">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-xs text-gray-400 uppercase font-medium mb-2 menu-text">Opérations</p>
            <a href="#" class="sidebar-link active">
                <i class="fas fa-th-large"></i>
                <span class="menu-text">Vue d'ensemble</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-calendar-check"></i>
                <span class="menu-text">Réservations</span>
                <span class="ml-auto bg-primary text-white text-xs py-1 px-2 rounded-full">4</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-cash-register"></i>
                <span class="menu-text">Caisse & Paiements</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-utensils"></i>
                <span class="menu-text">Commandes</span>
            </a>
        </div>
        
        <div class="mb-4">
            <p class="text-xs text-gray-400 uppercase font-medium mb-2 menu-text">Gestion</p>
            <a href="#" class="sidebar-link">
                <i class="fas fa-warehouse"></i>
                <span class="menu-text">Inventaire</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-users"></i>
                <span class="menu-text">Personnel</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Rapports</span>
            </a>
        </div>
        
        <div class="mt-auto pt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 hover:text-red-600">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>