{{-- resources/views/gerants/sections/menu.blade.php --}}
<div id="section-menu" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Menus et Plats</h2>
    
    {{-- Liste des menus --}}
    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 mb-6 overflow-hidden relative">
        <!-- Éléments décoratifs -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 dark:bg-blue-600/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-400/10 dark:bg-yellow-600/10 rounded-full -ml-12 -mb-12"></div>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 relative">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Menus disponibles</h3>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto relative z-10">
                {{-- Recherche --}}
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" placeholder="Rechercher un menu..." class="pl-10 pr-4 py-2.5 w-full md:w-52 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm" aria-label="Rechercher un menu">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                
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
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">Description</th>
                        <th width="120" class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody id="menu-table-body" class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Exemples de menus --}}
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
                </select>
                {{-- Bouton Ajouter --}}
                <button type="button" class="add-dish-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </div>
        </div>
        
        {{-- Affichage des plats sous forme de cartes --}}
        <div id="dishes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            {{-- Exemple de plats --}}
        </div>
    </div>

    {{-- Modal Ajouter/Modifier Menu --}}
    <div id="menu-modal" tabindex="-1" aria-labelledby="menu-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 id="menu-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Ajouter un menu</h3>
                <button type="button" data-close class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-4 space-y-4">
                <input type="hidden" id="menu-id">
                <div>
                    <label for="menu-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du menu</label>
                    <input type="text" id="menu-name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="menu-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description du menu</label>
                    <textarea id="menu-description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-menu" data-close type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
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
                <button type="button" data-close class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-4 space-y-4">
                <input type="hidden" id="dish-id">
                <div>
                    <label for="dish-image-url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL de l'image</label>
                    <input type="url" id="dish-image-url" placeholder="https://exemple.com/image.jpg" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Collez l'URL de l'image ici</p>
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
                    <input type="text" id="dish-category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Entrée, Plat principal, Dessert, etc.">
                </div>
                <div>
                    <label for="dish-price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix (DH)</label>
                    <input type="number" step="0.01" id="dish-price" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="dish-menu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Menu associé</label>
                    <select id="dish-menu" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">À la carte</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-dish" data-close type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
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
                
                <form id="delete-form" method="POST" class="mt-6">
                    @csrf
                    <div class="flex justify-center gap-3">
                        <button id="cancel-delete" type="button" data-close class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Annuler
                        </button>
                        <button id="confirm-delete" type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script JavaScript --}}

<script>
    // Variables globales
    let currentEditId = null;
    let currentEditType = null;
    let currentRestaurantId = null;
    let menus = [];
    let plats = [];

    // Initialisation : récupérer l'ID du restaurant sélectionné au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const restaurantSelector = document.getElementById('header-restaurant-selector');
        
        // Ajouter un écouteur d'événements sur le changement de restaurant
        restaurantSelector.addEventListener('change', function() {
            const restaurantId = this.value;
            if (restaurantId) {
                currentRestaurantId = restaurantId;
                loadMenusByRestaurant(restaurantId);
                loadPlatsByRestaurant(restaurantId);
            } else {
                // Réinitialiser l'affichage si aucun restaurant n'est sélectionné
                resetMenuDisplay();
                resetPlatDisplay();
            }
        });
        
        // Charger les données du restaurant actuellement sélectionné
        if (restaurantSelector.value) {
            currentRestaurantId = restaurantSelector.value;
            loadMenusByRestaurant(currentRestaurantId);
            loadPlatsByRestaurant(currentRestaurantId);
        }
    });

    // Événements pour ouvrir les modaux
    document.querySelector('.add-menu-button')?.addEventListener('click', () => {
        if (!currentRestaurantId) {
            alert('Veuillez d\'abord sélectionner un restaurant.');
            return;
        }
        openModal('menu', null);
    });

    document.querySelector('.add-dish-button')?.addEventListener('click', () => {
        if (!currentRestaurantId) {
            alert('Veuillez d\'abord sélectionner un restaurant.');
            return;
        }
        
        // Vérifier si des menus existent
        if (menus.length === 0) {
            alert('Veuillez d\'abord créer un menu avant d\'ajouter des plats.');
            return;
        }
        
        openModal('dish', null);
    });

    // Fonction pour charger les menus par restaurant
    function loadMenusByRestaurant(restaurantId) {
        fetch(`/gerant/menus/by-restaurant/${restaurantId}`)
            .then(response => response.json())
            .then(data => {
                menus = data.menus;
                updateMenuTable(menus);
                updateMenuDropdown(menus);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des menus:', error);
            });
    }

    // Fonction pour charger les plats par restaurant
    function loadPlatsByRestaurant(restaurantId) {
        console.log('Chargement des plats pour le restaurant:', restaurantId);
        fetch(`/gerant/plats/by-restaurant/${restaurantId}`)
            .then(response => {
                console.log('Réponse reçue:', response);
                return response.json();
            })
            .then(data => {
                console.log('Données de plats reçues:', data);
                plats = data.plats || [];
                updatePlatDisplay(plats);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des plats:', error);
            });
    }

    // Fonction pour mettre à jour l'affichage des menus
    function updateMenuTable(menus) {
        const tbody = document.querySelector('#menu-table-body');
        tbody.innerHTML = '';
        
        if (menus.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="3" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                    Aucun menu disponible pour ce restaurant.
                </td>
            `;
            tbody.appendChild(tr);
            return;
        }
        
        menus.forEach(menu => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors';
            tr.dataset.id = menu.id;
            tr.innerHTML = `
                <td class="px-5 py-4">
                    <div class="font-medium text-gray-900 dark:text-gray-100">${menu.nom}</div>
                </td>
                <td class="px-5 py-4">
                    <div class="text-sm text-gray-600 dark:text-gray-300">${menu.description || ''}</div>
                </td>
                <td class="px-5 py-4">
                    <div class="flex space-x-2">
                        <button type="button" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors" title="Modifier" onclick="editMenu(this)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="p-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md transition-colors" title="Voir les plats" onclick="filterPlatsByMenu(${menu.id})">
                            <i class="fas fa-list"></i>
                        </button>
                        <button type="button" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors" title="Supprimer" onclick="deleteItem(this, 'menu')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Fonction pour mettre à jour le dropdown de menus dans le formulaire de plat
    function updateMenuDropdown(menus) {
        const dropdown = document.getElementById('dish-menu');
        dropdown.innerHTML = '';
        
        // Option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'À la carte';
        dropdown.appendChild(defaultOption);
        
        // Ajouter les menus
        menus.forEach(menu => {
            const option = document.createElement('option');
            option.value = menu.id;
            option.textContent = menu.nom;
            dropdown.appendChild(option);
        });
    }

    // Fonction pour mettre à jour l'affichage des plats
    function updatePlatDisplay(plats) {
        console.log('Mise à jour de l\'affichage avec plats:', plats);
        const container = document.querySelector('#dishes-container');
        container.innerHTML = '';
        
        if (!plats || plats.length === 0) {
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'col-span-full text-center py-8 text-gray-500 dark:text-gray-400';
            emptyMessage.innerHTML = 'Aucun plat disponible pour ce restaurant.';
            container.appendChild(emptyMessage);
            return;
        }
        
        plats.forEach(plat => {
            console.log('Création de la carte pour le plat:', plat);
            const card = document.createElement('div');
            card.className = 'bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow';
            card.dataset.id = plat.id;
            card.dataset.menuId = plat.menu_id;
            card.innerHTML = `
                <div class="h-48 overflow-hidden">
                    ${plat.image ? `<img src="${plat.image}" alt="${plat.nom}" class="w-full h-full object-cover">` : 
                     '<div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-600"><i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i></div>'}
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">${plat.nom}</h4>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300">
                            ${plat.categorie || 'Non catégorisé'}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">${plat.description || ''}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-gray-200">${plat.prix} DH</span>
                        <div class="flex space-x-1">
                            <button type="button" class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Modifier" onclick="editDish(this)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer" onclick="deleteItem(this, 'dish')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // Fonction pour filtrer les plats par menu
    function filterPlatsByMenu(menuId) {
        if (menuId) {
            const filteredPlats = plats.filter(plat => plat.menu_id == menuId);
            updatePlatDisplay(filteredPlats);
            
            // Mettre en évidence le menu sélectionné dans la liste des menus
            const menuRows = document.querySelectorAll('#menu-table-body tr');
            menuRows.forEach(row => {
                if (row.dataset.id == menuId) {
                    row.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
                } else {
                    row.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                }
            });
        } else {
            updatePlatDisplay(plats);
            
            // Désélectionner tous les menus
            const menuRows = document.querySelectorAll('#menu-table-body tr');
            menuRows.forEach(row => {
                row.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
            });
        }
    }

    // Fonction pour réinitialiser l'affichage des menus
    function resetMenuDisplay() {
        const tbody = document.querySelector('#menu-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                    Veuillez sélectionner un restaurant pour voir les menus.
                </td>
            </tr>
        `;
        menus = [];
    }

    // Fonction pour réinitialiser l'affichage des plats
    function resetPlatDisplay() {
        const container = document.querySelector('#dishes-container');
        container.innerHTML = `
            <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                Veuillez sélectionner un restaurant pour voir les plats.
            </div>
        `;
        plats = [];
    }

    // Fonction pour ouvrir les modaux
    function openModal(type, data = null) {
        currentEditType = type;
        
        if (type === 'menu') {
            document.getElementById('menu-modal').classList.remove('hidden');
            document.getElementById('menu-modal').classList.add('flex');
            
            if (data) {
                // Mode édition
                document.getElementById('menu-modal-title').textContent = 'Modifier un menu';
                document.getElementById('menu-id').value = data.id;
                document.getElementById('menu-name').value = data.name;
                document.getElementById('menu-description').value = data.description || '';
            } else {
                // Mode création
                document.getElementById('menu-modal-title').textContent = 'Ajouter un menu';
                document.getElementById('menu-id').value = '';
                document.getElementById('menu-name').value = '';
                document.getElementById('menu-description').value = '';
            }
        } else {
            document.getElementById('dish-modal').classList.remove('hidden');
            document.getElementById('dish-modal').classList.add('flex');
            
            if (data) {
                // Mode édition
                document.getElementById('dish-modal-title').textContent = 'Modifier un plat';
                document.getElementById('dish-id').value = data.id;
                document.getElementById('dish-name').value = data.name;
                document.getElementById('dish-description').value = data.description || '';
                document.getElementById('dish-category').value = data.category || '';
                document.getElementById('dish-price').value = data.price;
                document.getElementById('dish-menu').value = data.menuId;
                document.getElementById('dish-image-url').value = data.image || '';
            } else {
                // Mode création
                document.getElementById('dish-modal-title').textContent = 'Ajouter un plat';
                document.getElementById('dish-id').value = '';
                document.getElementById('dish-name').value = '';
                document.getElementById('dish-description').value = '';
                document.getElementById('dish-category').value = '';
                document.getElementById('dish-price').value = '';
                document.getElementById('dish-menu').value = '';
                document.getElementById('dish-image-url').value = '';
            }
        }
    }

    // Fermer tous les modaux
    document.querySelectorAll('[id*="-modal"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal || e.target.closest('[data-close]') || e.target.closest('[aria-label="Fermer"]')) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentEditId = null;
                currentEditType = null;
            }
        });
    });

    // Gestionnaire de soumission des formulaires
    document.getElementById('save-menu')?.addEventListener('click', () => {
        const id = document.getElementById('menu-id').value;
        const formData = {
            nom: document.getElementById('menu-name').value,
            description: document.getElementById('menu-description').value,
            restaurant_id: currentRestaurantId
        };
        
        // URL et méthode en fonction de l'édition ou création
        const url = id ? `/gerant/menus/update/${id}` : '/gerant/menus/store';
        const method = id ? 'PUT' : 'POST';
        
        // Envoyer la requête
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Rafraîchir les données
                loadMenusByRestaurant(currentRestaurantId);
                
                // Fermer le modal
                document.getElementById('menu-modal').classList.add('hidden');
                document.getElementById('menu-modal').classList.remove('flex');
                
                // Afficher un message de succès avec notre nouvelle fonction
                showAlert('success', 'Succès', data.message);
            } else {
                showAlert('error', 'Erreur', data.message || 'Une erreur est survenue.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('error', 'Erreur', 'Une erreur est survenue lors de la communication avec le serveur.');
        });
    });

    document.getElementById('save-dish')?.addEventListener('click', () => {
        const id = document.getElementById('dish-id').value;
        const formData = {
            nom: document.getElementById('dish-name').value,
            description: document.getElementById('dish-description').value,
            prix: document.getElementById('dish-price').value,
            menu_id: document.getElementById('dish-menu').value,
            categorie: document.getElementById('dish-category').value,
            image: document.getElementById('dish-image-url').value || ''
        };
        
        // URL et méthode en fonction de l'édition ou création
        const url = id ? `/gerant/plats/update/${id}` : '/gerant/plats/store';
        const method = id ? 'PUT' : 'POST';
        
        // Envoyer la requête
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Rafraîchir les données
                loadPlatsByRestaurant(currentRestaurantId);
                
                // Fermer le modal
                document.getElementById('dish-modal').classList.add('hidden');
                document.getElementById('dish-modal').classList.remove('flex');
                
                // Afficher un message de succès avec notre système d'alerte
                showAlert('success', 'Succès', data.message);
            } else {
                showAlert('error', 'Erreur', data.message || 'Une erreur est survenue.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('error', 'Erreur', 'Une erreur est survenue lors de la communication avec le serveur.');
        });
    });

    // Fonction de suppression
    function deleteItem(button, type) {
        // Récupérer l'ID directement à partir du bouton parent
        const parentElement = button.closest('tr, div[data-id]');
        if (!parentElement) {
            console.error("Élément parent non trouvé");
            return;
        }
        
        currentEditId = parentElement.dataset.id;
        currentEditType = type;
        
        console.log("Suppression - Type:", type, "ID:", currentEditId);
        
        if (!currentEditId || currentEditId === 'undefined') {
            alert("Impossible de trouver l'identifiant de l'élément à supprimer.");
            return;
        }
        
        // Ouvrir la modal de confirmation
        const deleteModal = document.getElementById('delete-confirmation-modal');
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        
        // Mettre à jour l'action du formulaire
        const form = document.getElementById('delete-form');
        const url = type === 'menu' ? 
            `/gerant/menus/supprimer/${currentEditId}` : 
            `/gerant/plats/supprimer/${currentEditId}`;
        
        console.log("URL de suppression:", url);
        form.action = url;
    }

    // Gestionnaire d'événement pour le bouton de confirmation de suppression
    document.getElementById('confirm-delete')?.addEventListener('click', function(e) {
        e.preventDefault(); // Empêcher la soumission normale du formulaire
        
        if (currentEditId && currentEditType) {
            // Récupérer le formulaire
            const form = document.getElementById('delete-form');
            const url = currentEditType === 'menu' ? 
                `/gerant/menus/supprimer/${currentEditId}` : 
                `/gerant/plats/supprimer/${currentEditId}`;
            
            form.action = url;
            
            // Utiliser fetch pour soumettre le formulaire de manière asynchrone
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fermer la modal
                    document.getElementById('delete-confirmation-modal').classList.add('hidden');
                    document.getElementById('delete-confirmation-modal').classList.remove('flex');
                    
                    // Rafraîchir la page complète
                    window.location.reload();
                } else {
                    alert('Erreur: ' + (data.message || 'Une erreur est survenue.'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la suppression.');
            });
        }
    });

    // Fonctions d'édition
    window.editMenu = function(button) {
        const tr = button.closest('tr');
        const data = {
            id: tr.dataset.id,
            name: tr.querySelector('td:first-child .font-medium').textContent,
            description: tr.querySelector('td:nth-child(2) .text-sm')?.textContent || ''
        };
        openModal('menu', data);
    };

    window.editDish = function(button) {
        const card = button.closest('.grid > div');
        const data = {
            id: card.dataset.id,
            name: card.querySelector('h4').textContent,
            description: card.querySelector('.line-clamp-2')?.textContent || '',
            category: card.querySelector('span')?.textContent.trim() || '',
            price: card.querySelector('.font-bold')?.textContent.replace(' DH', '') || '',
            menuId: card.dataset.menuId || '',
            image: card.querySelector('img')?.src || ''
        };
        openModal('dish', data);
    };

    // La fonction pour filtrer les plats par menu est disponible globalement
    window.filterPlatsByMenu = filterPlatsByMenu;
</script>