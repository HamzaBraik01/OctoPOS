<nav class="bg-gray-800 text-white shadow-lg fixed w-full z-50 top-0 left-0">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="#" class="logo-container flex items-center" aria-label="OctoPOS Home">
            <div class="relative mr-2">
                <i class="fas fa-utensils text-[#4CAF50] text-3xl absolute -top-1 -left-1 opacity-30"></i>
                <i class="fas fa-utensils text-[#0288D1] text-3xl"></i>
            </div>
            <span class="logo-text text-3xl">OctoPOS</span>
        </a>

        <!-- Navigation Links - Desktop -->
        <div class="hidden md:flex space-x-8">
            <a href="#about" class="text-gray-300 hover:text-white transition duration-300">À propos</a>
            <a href="#menu" class="text-gray-300 hover:text-white transition duration-300">Menu</a>
            <a href="#tables" class="text-gray-300 hover:text-white transition duration-300">Tables</a>
            <a href="#chefs" class="text-gray-300 hover:text-white transition duration-300">Nos Chefs</a>
            <a href="#contact" class="text-gray-300 hover:text-white transition duration-300">Contact</a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden flex items-center" aria-label="Toggle menu">
            <i class="fas fa-bars text-white text-xl"></i>
        </button>

        <!-- Auth Buttons -->
        <div class="hidden md:flex space-x-4">
            <button class="bg-transparent text-white border border-white hover:bg-white/10 rounded-full px-4 py-2 transition duration-300 flex items-center">
                <a href="{{ route('login') }}" class="flex items-center">
                    <i class="fas fa-user mr-2"></i> Connexion
                </a>
            </button>
            <button class="bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white hover:from-[#026da8] hover:to-[#0288D1] rounded-full px-4 py-2 transition duration-300 flex items-center shadow-md">
                <a href="{{ route('register') }}" class="flex items-center">
                    <i class="fas fa-plus mr-2"></i> Inscription
                </a>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="md:hidden hidden bg-gray-700 border-t border-gray-600 py-4">
        <div class="container mx-auto px-4 flex flex-col space-y-4">
            <a href="#about" class="text-gray-200 hover:text-white py-2 transition duration-300">À propos</a>
            <a href="#menu" class="text-gray-200 hover:text-white py-2 transition duration-300">Menu</a>
            <a href="#tables" class="text-gray-200 hover:text-white py-2 transition duration-300">Tables</a>
            <a href="#chefs" class="text-gray-200 hover:text-white py-2 transition duration-300">Nos Chefs</a>
            <a href="#contact" class="text-gray-200 hover:text-white py-2 transition duration-300">Contact</a>
            <div class="flex space-x-2 pt-2">
                <button class="w-1/2 bg-transparent text-white border border-white hover:bg-white/10 rounded-full px-4 py-2 transition duration-300 flex items-center justify-center">
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full">
                        <i class="fas fa-user mr-2"></i> Connexion
                    </a>
                </button>
                <button class="w-1/2 bg-gradient-to-r from-[#0288D1] to-[#026da8] text-white hover:from-[#026da8] hover:to-[#0288D1] rounded-full px-4 py-2 transition duration-300 flex items-center justify-center">
                    <a href="{{ route('register') }}" class="flex items-center justify-center w-full">
                        <i class="fas fa-plus mr-2"></i> Inscription
                    </a>
                </button>
            </div>
        </div>
    </div>
</nav>