<header id="header" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 fixed right-0 top-0 z-40 py-3 px-6 w-[calc(100%-16rem)] transition-all">
    <div id="alert-container" class="fixed top-5 right-5 z-50 max-w-md w-full flex flex-col gap-3 transition-all">
    </div>
    
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <button id="mobile-menu-toggle" class="mr-4 text-gray-500 dark:text-gray-300 lg:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Supervision Opérationnelle</h1>
            
            <div class="ml-4">
                <select id="header-restaurant-selector" class="text-sm px-3 py-1.5 pr-8 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">Sélectionner un restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ isset($selectedRestaurantId) && $selectedRestaurantId == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->nom }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="flex items-center space-x-2 sm:space-x-4">
            
            <div id="theme-toggle" class="theme-toggle mx-2">
                <span class="sr-only">Basculer le thème jour/nuit</span>
            </div>

            <div id="current-date-time" class="text-sm text-gray-600 dark:text-gray-300 hidden sm:block"></div>

            @auth
            <div class="flex items-center ml-4 relative">
                <div class="w-9 h-9 rounded-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-user"></i>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gérant</p>
                </div>
            </div>
            @endauth
        </div>
    </div>
</header>

<template id="reservation-item-template">
    <div class="reservation-item p-3 hover:bg-gray-50 dark:hover:bg-gray-700/30">
        <div class="flex justify-between items-start">
            <div>
                <div class="font-medium text-gray-800 dark:text-gray-200">
                    <span class="reservation-time"></span> - <span class="reservation-client"></span>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="reservation-table"></span> • <span class="reservation-persons"></span> pers.
                </div>
            </div>
            <div class="reservation-status"></div>
        </div>
        <div class="mt-2 flex space-x-1">
            <button class="reservation-arrive p-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded" title="Marquer Arrivé">
                <i class="fas fa-check"></i>
            </button>
            <button class="reservation-cancel p-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Annuler">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</template>

<template id="alert-template">
    <div class="alert-item flex items-start p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out translate-x-full opacity-0">
        <div class="flex-shrink-0 mr-3">
            <i class="alert-icon fas fa-check-circle text-xl"></i>
        </div>
        <div class="flex-grow">
            <h4 class="alert-title text-sm font-semibold mb-1"></h4>
            <p class="alert-message text-sm"></p>
        </div>
        <button class="alert-close ml-3 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>

<script>
    function showAlert(type, title, message, duration = 5000) {
        const container = document.getElementById('alert-container');
        const template = document.getElementById('alert-template');
        const alert = template.content.cloneNode(true).querySelector('.alert-item');
        
        switch (type) {
            case 'success':
                alert.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-800', 'dark:text-green-200');
                alert.querySelector('.alert-icon').classList.add('text-green-500', 'dark:text-green-400');
                break;
            case 'error':
                alert.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-800', 'dark:text-red-200');
                alert.querySelector('.alert-icon').classList.add('text-red-500', 'dark:text-red-400');
                alert.querySelector('.alert-icon').classList.remove('fa-check-circle');
                alert.querySelector('.alert-icon').classList.add('fa-exclamation-circle');
                break;
            case 'warning':
                alert.classList.add('bg-yellow-100', 'dark:bg-yellow-900/30', 'text-yellow-800', 'dark:text-yellow-200');
                alert.querySelector('.alert-icon').classList.add('text-yellow-500', 'dark:text-yellow-400');
                alert.querySelector('.alert-icon').classList.remove('fa-check-circle');
                alert.querySelector('.alert-icon').classList.add('fa-exclamation-triangle');
                break;
            case 'info':
                alert.classList.add('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-800', 'dark:text-blue-200');
                alert.querySelector('.alert-icon').classList.add('text-blue-500', 'dark:text-blue-400');
                alert.querySelector('.alert-icon').classList.remove('fa-check-circle');
                alert.querySelector('.alert-icon').classList.add('fa-info-circle');
                break;
        }
        
        alert.querySelector('.alert-title').textContent = title;
        alert.querySelector('.alert-message').textContent = message;
        
        container.appendChild(alert);
        
        setTimeout(() => {
            alert.classList.remove('translate-x-full', 'opacity-0');
        }, 10);
        
        alert.querySelector('.alert-close').addEventListener('click', () => {
            closeAlert(alert);
        });
        
        if (duration > 0) {
            setTimeout(() => {
                closeAlert(alert);
            }, duration);
        }
        
        return alert;
    }
    
    function closeAlert(alert) {
        alert.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
    
    window.showAlert = showAlert;
    window.closeAlert = closeAlert;
</script>