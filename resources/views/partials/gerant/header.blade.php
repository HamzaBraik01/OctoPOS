<header class="dashboard-header" id="header">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <button id="mobile-menu-toggle" class="mr-4 text-gray-500 hidden">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-lg font-semibold text-primary">Supervision Opérationnelle</h1>
            
            <div class="ml-3">
                <select id="restaurant-selector" class="text-xs bg-blue-100 text-blue-800 font-medium py-1 px-2 rounded dark:bg-blue-900 dark:text-blue-200 border-none focus:ring-2 focus:ring-blue-300">
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Live Counter -->
            <div class="hidden md:flex items-center mr-2 text-sm px-3 py-1 bg-success bg-opacity-10 text-success rounded-full">
                <div class="w-2 h-2 rounded-full bg-success mr-2 animate-ping"></div>
                <span>24 clients présents</span>
            </div>
            
            <!-- Crisis Toggle -->
            <div class="crisis-toggle">
                <span class="crisis-toggle-label text-sm font-medium">Mode Crise</span>
                <button id="crisis-toggle-button" class="crisis-toggle-button"></button>
            </div>
            
            <!-- Day/Night toggle -->
            <div id="theme-toggle" class="theme-toggle mx-2">
                <span class="sr-only">Basculer le thème jour/nuit</span>
            </div>
            
            <!-- Current time -->
            <div class="hidden md:block text-sm text-gray-600 dark:text-gray-300">
                <span id="current-date-time">2025-04-09 23:14:13</span>
            </div>
            
            <div class="border-l border-gray-300 dark:border-gray-700 h-6 mx-2"></div>
            
            <!-- Notifications -->
            <div class="relative">
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-danger text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">5</span>
                </button>
            </div>
            
            <!-- Profile -->
            <div class="flex items-center">
                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold mr-2">
                    HB
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-semibold">Hamza Br</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gérant</p>
                </div>
            </div>
        </div>
    </div>
</header>