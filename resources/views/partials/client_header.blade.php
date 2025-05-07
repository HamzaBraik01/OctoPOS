<header class="dashboard-header" id="header">
    <div class="flex items-center justify-between">
        <!-- Mobile Menu Toggle and Title -->
        <div class="flex items-center">
            <button id="mobile-menu-toggle" class="mr-4 text-[var(--text-secondary)] hidden focus:outline-none p-1">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-lg font-semibold" style="color: var(--text-primary);">Espace Client</h1>
        </div>

        <!-- Header Controls -->
        <div class="flex items-center space-x-3 sm:space-x-4">
             <!-- Search Bar (Optional) -->
             <div class="relative hidden md:block">
                <input type="text" class="form-input !py-1.5 pl-10 !w-48 lg:!w-64" placeholder="Rechercher...">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-[var(--text-secondary)]"></i>
            </div>

            <!-- Theme Toggle -->
             <div id="theme-toggle" class="theme-toggle">
                <span class="sr-only">Basculer le thème jour/nuit</span>
            </div>

            <div class="border-l h-6" style="border-color: var(--border-color);"></div>

            <!-- Profile Dropdown -->
            <div class="relative">
                 @auth
                 <button class="flex items-center space-x-2 focus:outline-none">
                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full border-2 object-cover" style="border-color: var(--primary);">
                    <span class="hidden md:inline-block font-medium text-sm" style="color: var(--text-primary);">{{ Auth::user()->name }}</span>
                </button>
                 @else
                 <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Connexion</a>
                 @endauth
                <!-- Profile Dropdown Menu would go here -->
            </div>
        </div>
    </div>
</header>