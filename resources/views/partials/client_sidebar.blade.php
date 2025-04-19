<aside class="sidebar" id="sidebar">
    <div class="p-4">
        <!-- Logo and Desktop Toggle -->
        <div class="flex items-center mb-8">
            <div class="flex items-center mr-2 flex-grow">
                {{-- Consider making the logo dynamic or configurable --}}
                <i class="fas fa-utensils text-secondary text-2xl mr-2"></i>
                <span class="logo-text text-2xl font-bold bg-gradient-to-r from-[#0288D1] to-[#4CAF50] bg-clip-text text-transparent">OctoPOS</span>
            </div>
            <button id="sidebar-toggle" class="ml-auto text-[var(--text-secondary)] hover:text-[var(--text-primary)] focus:outline-none p-1">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav>
             <p class="text-xs uppercase font-medium mb-2 menu-text px-4" style="color: var(--text-secondary);">Menu</p>
             {{-- Use route() helper when you define routes --}}
             <a class="sidebar-link" href="#dashboard"> {{-- Add 'active' class dynamically based on route --}}
                 <i class="fas fa-home"></i><span class="menu-text">Tableau de bord</span>
             </a>
             <a class="sidebar-link" href="#reservations">
                 <i class="fas fa-calendar-alt"></i><span class="menu-text">Mes Réservations</span>
             </a>
             <a class="sidebar-link" href="#tables">
                 <i class="fas fa-chair"></i><span class="menu-text">Réserver une Table</span>
             </a>
             <a class="sidebar-link" href="#invoices">
                 <i class="fas fa-file-invoice-dollar"></i><span class="menu-text">Mes Factures</span>
             </a>
             <a class="sidebar-link" href="#profile">
                 <i class="fas fa-user"></i><span class="menu-text">Mon Profil</span>
             </a>
         </nav>

         <!-- Footer Links -->
        <div class="mt-auto pt-8">
            <p class="text-xs uppercase font-medium mb-2 menu-text px-4" style="color: var(--text-secondary);">Compte</p>
            {{-- Example Logout Form (adjust action as needed) --}}
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                 <a href="{{ route('logout') }}"
                    @click.prevent="$root.submit();"
                    class="sidebar-link"
                    style="color: var(--danger);"
                    onmouseover="this.style.backgroundColor='rgba(var(--danger-rgb), 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">{{ __('Déconnexion') }}</span>
                </a>
            </form>
        </div>
    </div>
</aside>