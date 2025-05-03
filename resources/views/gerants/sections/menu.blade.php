{{-- resources/views/gerants/sections/menu.blade.php --}}
<div id="section-menu" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Menus et Plats</h2>

    {{-- Liste des menus --}}
    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 mb-6 overflow-hidden relative">
        <!-- Élément décoratif -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 dark:bg-blue-600/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-400/10 dark:bg-yellow-600/10 rounded-full -ml-12 -mb-12"></div>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 relative">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Menus disponibles
                </h3>
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto relative z-10">
                {{-- Recherche --}}
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" placeholder="Rechercher un menu..." class="pl-10 pr-4 py-2.5 w-full md:w-52 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm" aria-label="Rechercher un menu">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                {{-- Filtres --}}
                <select class="px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm" aria-label="Filtrer par catégorie">
                    <option value="">Toutes les catégories</option>
                    <option value="entrée">Entrées</option>
                    <option value="plat">Plats principaux</option>
                    <option value="dessert">Desserts</option>
                    <option value="boisson">Boissons</option>
                </select>
                {{-- Bouton Ajouter --}}
                <button type="button" class="add-menu-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg flex items-center transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </div>
        </div>

        {{-- Tableau des menus --}}
        <div class="overflow-x-auto relative z-10 bg-white dark:bg-gray-800/80 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">Nom</th>
                        <th width="120" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Les données réelles viendraient d'une boucle @foreach($menus as $menu) --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100">Menu du jour</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex space-x-2">
                                <button type="button" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md transition-colors" title="Voir les plats">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100">Menu enfant</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex space-x-2">
                                <button type="button" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md transition-colors" title="Voir les plats">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Exemple d'un menu supplémentaire -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100">Menu Découverte</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex space-x-2">
                                <button type="button" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md transition-colors" title="Voir les plats">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-between items-center mt-5 relative z-10">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Affichage de <span class="font-medium">1</span> à <span class="font-medium">3</span> sur <span class="font-medium">3</span> menus
            </div>
            <div class="flex space-x-1">
                <button disabled class="px-3 py-1.5 text-sm text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 rounded-md cursor-not-allowed">
                    Précédent
                </button>
                <button disabled class="px-3 py-1.5 text-sm text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 rounded-md cursor-not-allowed">
                    Suivant
                </button>
            </div>
        </div>
    </div>

    {{-- Liste des plats --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h3 class="text-lg font-semibold flex items-center text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-hamburger text-blue-500 mr-2"></i>
                Plats disponibles
            </h3>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                {{-- Recherche --}}
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" placeholder="Rechercher un plat..." class="pl-10 pr-4 py-2 w-full md:w-48 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Rechercher un plat">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                {{-- Filtres --}}
                <select class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Filtrer par menu">
                    <option value="">Tous les menus</option>
                    <option value="menu-jour">Menu du jour</option>
                    <option value="menu-enfant">Menu enfant</option>
                    <option value="carte">À la carte</option>
                </select>
                {{-- Bouton Ajouter --}}
                <button type="button" class="add-dish-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </div>
        </div>

        {{-- Affichage des plats sous forme de cartes --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            {{-- Les données réelles viendraient d'une boucle @foreach($plats as $plat) --}}
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.pexels.com/photos/376464/pexels-photo-376464.jpeg" alt="Couscous royal" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Couscous royal</h4>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300">
                            Plat principal
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">Couscous avec agneau, poulet et merguez</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-gray-200">18,00 DH</span>
                        <div class="flex space-x-1">
                            <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.pexels.com/photos/1256931/pexels-photo-1256931.jpeg" alt="Tajine poulet citron" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Tajine poulet citron</h4>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300">
                            Plat principal
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">Tajine de poulet aux olives et citron confit</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-gray-200">16,00 DH</span>
                        <div class="flex space-x-1">
                            <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.pexels.com/photos/2092507/pexels-photo-2092507.jpeg" alt="Pastilla au poulet" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Pastilla au poulet</h4>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">
                            Entrée
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">Pastilla traditionnelle au poulet et amandes</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-gray-200">12,00 DH</span>
                        <div class="flex space-x-1">
                            <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                <div class="h-48 overflow-hidden">
                    <img src="https://images.pexels.com/photos/1070850/pexels-photo-1070850.jpeg" alt="Crème Brûlée" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Crème Brûlée</h4>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                            Dessert
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">Dessert crémeux avec croûte caramélisée</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-gray-200">8,00 DH</span>
                        <div class="flex space-x-1">
                            <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Ajouter/Modifier Menu --}}
    <div id="menu-modal" tabindex="-1" aria-labelledby="menu-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 id="menu-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Ajouter un menu</h3>
                <button type="button" id="close-menu-modal-x" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="menu-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du menu</label>
                    <input type="text" id="menu-name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="menu-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="menu-description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>
                <div>
                    <label for="menu-category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                    <select id="menu-category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="formule">Formule</option>
                        <option value="carte">À la carte</option>
                        <option value="special">Menu spécial</option>
                    </select>
                </div>
                <div>
                    <label for="menu-price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix (DH)</label>
                    <input type="number" step="0.01" id="menu-price" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="menu-available" class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="menu-available" class="text-sm font-medium text-gray-700 dark:text-gray-300">Disponible</label>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-menu" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Annuler
                </button>
                <button id="save-menu" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Ajouter/Modifier Plat --}}
    <div id="dish-modal" tabindex="-1" aria-labelledby="dish-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 id="dish-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Ajouter un plat</h3>
                <button type="button" id="close-dish-modal-x" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="dish-image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image du plat</label>
                    <div class="flex items-center">
                        <div class="w-20 h-20 mr-3 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                            <img id="dish-image-preview" src="" alt="Aperçu" class="h-full w-full object-cover hidden">
                            <i id="dish-image-placeholder" class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <input type="file" id="dish-image-upload" accept="image/*" class="sr-only">
                            <label for="dish-image-upload" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 rounded-md inline-block cursor-pointer text-sm">
                                Choisir une image
                            </label>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, GIF jusqu'à 2MB</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="dish-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du plat</label>
                    <input type="text" id="dish-name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="dish-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="dish-description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>
                <div>
                    <label for="dish-category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                    <select id="dish-category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="entrée">Entrée</option>
                        <option value="plat">Plat principal</option>
                        <option value="dessert">Dessert</option>
                        <option value="boisson">Boisson</option>
                    </select>
                </div>
                <div>
                    <label for="dish-price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix (DH)</label>
                    <input type="number" step="0.01" id="dish-price" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="dish-menu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Menu associé</label>
                    <select id="dish-menu" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">À la carte</option>
                        <option value="1">Menu du jour</option>
                        <option value="2">Menu enfant</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="dish-available" class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="dish-available" class="text-sm font-medium text-gray-700 dark:text-gray-300">Disponible</label>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-dish" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Annuler
                </button>
                <button id="save-dish" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation de suppression --}}
    <div id="delete-confirmation-modal" tabindex="-1" aria-labelledby="delete-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto" role="dialog" aria-modal="true">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                    <i class="fas fa-trash-alt text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 id="delete-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Confirmer la suppression</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.
                </p>
                <div class="mt-6 flex justify-center gap-3">
                    <button id="cancel-delete" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Annuler
                    </button>
                    <button id="confirm-delete" type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>