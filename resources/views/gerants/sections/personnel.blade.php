{{-- resources/views/gerants/sections/personnel.blade.php --}}
<div id="section-personnel" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion du Personnel</h2>

    {{-- Message flash pour les opérations réussies --}}
    @if(session('success'))
    <div id="success-alert" class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-gray-200 rounded-lg flex items-start">
        <div class="mr-3 flex-shrink-0">
            <i class="fas fa-check-circle text-2xl text-green-500 dark:text-green-400"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-medium">Succès</h4>
            <p class="text-xs mt-1">{{ session('success') }}</p>
        </div>
        <button type="button" class="ml-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Liste du personnel --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h3 class="text-lg font-semibold flex items-center text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-users text-blue-500 mr-2"></i>
                Membres du restaurant
            </h3>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                {{-- Recherche --}}
                <div class="relative flex-grow md:flex-grow-0">
                    <input type="text" id="personnel-search" placeholder="Rechercher..." class="pl-10 pr-4 py-2 w-full md:w-48 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Rechercher un employé">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                {{-- Filtre Rôle --}}
                <select id="personnel-role-filter" class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500" aria-label="Filtrer par rôle">
                    <option value="">Tous les rôles</option>
                    <option value="serveur">Serveur</option>
                    <option value="cuisinier">Cuisinier</option>
                    <option value="client">Client</option>
                </select>
            </div>
        </div>

        {{-- Tableau des employés --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Employé</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Contact</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Rôle</th>
                        <th class="px-4 py-3 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody id="personnel-table-body" class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Les données seront chargées dynamiquement ici --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
            <div id="pagination-info">Affichage de 1-5 employés sur 12</div>
            <div id="pagination-controls" class="flex items-center space-x-1">
                <button id="prev-page" class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 disabled:opacity-50" disabled>Préc.</button>
                <div id="page-buttons" class="flex items-center space-x-1">
                    {{-- Page buttons will be populated here --}}
                </div>
                <button id="next-page" class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Suiv.</button>
            </div>
        </div>
    </div>

    {{-- Planification des horaires --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                Planification Hebdomadaire
            </h3>
            <div class="flex items-center">
                <button type="button" class="add-shift-button text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center font-medium">
                    <i class="fas fa-plus-circle mr-1"></i> Ajouter Créneau
                </button>
            </div>
        </div>

        {{-- Filtres rapides de période --}}
        <div class="flex mb-4 space-x-2 overflow-x-auto py-2">
            <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-blue-500">Cette semaine</button>
            <button class="schedule-filter-btn">Sem. Prochaine</button>
            <button class="schedule-filter-btn">Aujourd'hui</button>
            <button class="schedule-filter-btn">Vue Mensuelle</button>
            {{-- Style commun pour les boutons filtre --}}
            <style>.schedule-filter-btn { font-size: 0.75rem; background-color: white; color: #4B5563; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #D1D5DB; white-space: nowrap; transition: background-color 0.2s; } .dark .schedule-filter-btn { background-color: #374151; color: #D1D5DB; border-color: #4B5563; } .schedule-filter-btn:hover { background-color: #F3F4F6; } .dark .schedule-filter-btn:hover { background-color: #4B5563; }</style>
        </div>

        {{-- Tableau de planning --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]"> {{-- Très large --}}
                <thead>
                    <tr>
                        <th class="py-2 px-2 sticky left-0 bg-white dark:bg-gray-800 z-10 w-40">Employé</th> {{-- Colonne Employé fixe --}}
                        {{-- Générer les jours de la semaine dynamiquement ? --}}
                        <th class="schedule-header" colspan="2">Lundi 29/04</th>
                        <th class="schedule-header" colspan="2">Mardi 30/04</th>
                        <th class="schedule-header" colspan="2">Mercredi 01/05</th>
                        <th class="schedule-header" colspan="2">Jeudi 02/05</th>
                        <th class="schedule-header" colspan="2">Vendredi 03/05</th>
                        <th class="schedule-header" colspan="2">Samedi 04/05</th>
                        <th class="schedule-header" colspan="2">Dimanche 05/05</th>
                         {{-- Style commun pour header planning --}}
                        <style>.schedule-header { padding: 0.5rem 0.25rem; text-align: center; background-color: #F3F4F6; font-size: 0.75rem; font-weight: 500; border-left: 1px solid #E5E7EB; border-bottom: 1px solid #E5E7EB; } .dark .schedule-header { background-color: #374151; border-color: #4B5563; color: #D1D5DB; }</style>
                    </tr>
                    <tr class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                        <th class="py-1 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700"></th>
                        {{-- Répéter pour chaque jour --}}
                        @for ($i = 0; $i < 7; $i++)
                        <th class="py-1 px-1 text-center border-l border-b dark:border-gray-700">Matin</th>
                        <th class="py-1 px-1 text-center border-l border-b dark:border-gray-700">Soir</th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    {{-- Boucle sur les employés --}}
                    {{-- @foreach($employees as $employee) --}}
                    {{-- Ligne exemple 1 --}}
                    <tr>
                        <td class="py-2 pr-2 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700 w-40 align-top">
                            <div class="flex items-start">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="w-8 h-8 rounded-full mr-2 mt-1 flex-shrink-0">
                                <div class="font-medium text-sm text-gray-900 dark:text-gray-100 mt-1">Thomas Dubois</div>
                            </div>
                        </td>
                        {{-- Boucle sur les jours/shifts --}}
                        @for ($i = 0; $i < 7; $i++)
                             {{-- Shift Matin --}}
                             <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]">
                                <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </td>
                             {{-- Shift Soir --}}
                            <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]">
                                @if($i == 0 || $i == 1 || $i == 3 || $i == 4 || $i == 5) {{-- Exemple de créneau assigné --}}
                                <div class="shift-card bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                    <span>Chef rang</span>
                                    <button class="delete-shift-btn"><i class="fas fa-times"></i></button>
                                </div>
                                @else
                                 <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                @endif
                            </td>
                        @endfor
                    </tr>
                     {{-- Ligne exemple 2 (Absence) --}}
                     <tr>
                         <td class="py-2 pr-2 sticky left-0 bg-white dark:bg-gray-800 z-10 border-b dark:border-gray-700 w-40 align-top"> <div class="flex items-start"> <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophie Renaud" class="w-8 h-8 rounded-full mr-2 mt-1 flex-shrink-0"> <div class="font-medium text-sm text-gray-900 dark:text-gray-100 mt-1">Sophie Renaud</div> </div> </td>
                         @for ($i = 0; $i < 7; $i++)
                             @if($i < 3) {{-- Exemple absence --}}
                             <td colspan="2" class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[140px]">
                                 <div class="shift-card absence-card bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">
                                     <i class="fas fa-ban mr-1"></i> Absente <span class="text-[10px]">(Maladie)</span>
                                     <button class="delete-shift-btn"><i class="fas fa-times"></i></button>
                                 </div>
                             </td>
                             @else {{-- Exemple dispo/non assigné --}}
                              <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]"> <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400"> <i class="fas fa-plus text-xs"></i> </button> </td>
                              <td class="p-1 border-l border-b dark:border-gray-700 align-top min-w-[70px]"> <button type="button" class="add-shift-button w-full h-full min-h-[40px] border border-dashed border-gray-300 dark:border-gray-600 rounded flex items-center justify-center text-gray-400 hover:text-blue-500 hover:border-blue-500 dark:hover:border-blue-400"> <i class="fas fa-plus text-xs"></i> </button> </td>
                             @endif
                             {{-- Ajustement pour ne pas dépasser 7 jours --}}
                              @if ($i == 2 && $i < 3) @php $i = 2; continue; @endphp @endif
                          @endfor
                      </tr>

                    {{-- @endforeach --}}
                     {{-- Style pour les cartes de shift --}}
                    <style>
                        .shift-card { position: relative; padding: 0.3rem 0.4rem; border-radius: 0.25rem; font-size: 0.7rem; line-height: 1.1; text-align: center; min-height: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
                        .shift-card span { display: block; margin-bottom: 0.1rem; font-weight: 500; }
                        .shift-card .delete-shift-btn { position: absolute; top: 0; right: 0; padding: 0.1rem; line-height: 0.8; color: inherit; opacity: 0.5; background: none; border: none; cursor: pointer; }
                        .shift-card:hover .delete-shift-btn { opacity: 1; }
                         .absence-card { font-weight: 500; }
                    </style>
                </tbody>
            </table>
        </div>
    </div>


    <div id="schedule-modal" tabindex="-1" aria-labelledby="schedule-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 id="schedule-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Ajouter un créneau</h3>
                <button type="button" id="close-schedule-modal-x" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Fermer">
                     <i class="fas fa-times text-xl"></i>
                 </button>
             </div>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="schedule-employee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employé</label>
                    <select id="schedule-employee" class="modal-input"> {{-- Utilise style commun --}}
                        <option value="">Sélectionner...</option>
                        {{-- Boucle @foreach($employees as $emp) <option value="{{$emp->id}}">{{$emp->name}}</option> @endforeach --}}
                        <option value="1">Thomas Dubois</option>
                        <option value="2">Marie Strauss</option>
                        <option value="3">Sophie Renaud</option>
                    </select>
                </div>
                <div>
                    <label for="schedule-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" id="schedule-date" class="modal-input">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="schedule-start-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure début</label>
                        <input type="time" id="schedule-start-time" class="modal-input">
                    </div>
                    <div>
                        <label for="schedule-end-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Heure fin</label>
                        <input type="time" id="schedule-end-time" class="modal-input">
                    </div>
                </div>
                 <div>
                    <label for="schedule-role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rôle (optionnel)</label>
                    <select id="schedule-role" class="modal-input">
                        <option value="serveur">Serveur</option>
                        <option value="client">Client</option>
                        {{-- etc. --}}
                    </select>
                </div>
                 <div>
                    <label for="schedule-notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                    <textarea id="schedule-notes" class="modal-input" rows="2"></textarea>
                </div>
            </div>
             <div class="mt-6 pt-4 border-t dark:border-gray-600 flex justify-end gap-3">
                <button id="cancel-schedule" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Annuler
                </button>
                <button id="save-schedule" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

     <div id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-title" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4">
         <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-5 sm:p-6 max-w-md w-full mx-auto" role="dialog" aria-modal="true">
            <div class="text-center">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                    <i class="fas fa-user-times text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <h3 id="delete-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">Supprimer cet employé ?</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Êtes-vous sûr ? Cette action est irréversible et toutes les données associées (horaires, etc.) pourraient être perdues. <span id="employee-name-placeholder" class="font-semibold"></span>
                </p>
                <div class="mt-6 flex justify-center gap-3">
                    <button id="cancel-delete-btn" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Annuler
                    </button>
                    <form id="delete-user-form" method="POST" action="" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Supprimer Employé
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables pour la pagination et le filtrage
    let currentPage = 1;
    let totalPages = 1;
    let searchQuery = '';
    let roleFilter = '';
    let selectedRestaurantId = null;
    let userToDelete = null;

    // Initialiser le gestionnaire de personnel lorsque le restaurant est sélectionné
    document.getElementById('header-restaurant-selector').addEventListener('change', function() {
        selectedRestaurantId = this.value;
        if (selectedRestaurantId) {
            currentPage = 1;
            loadPersonnel();
        }
    });

    // Gestionnaire pour la recherche
    document.getElementById('personnel-search').addEventListener('input', function() {
        searchQuery = this.value.trim();
        currentPage = 1; // Réinitialiser à la première page
        loadPersonnel();
    });

    // Gestionnaire pour le filtre de rôle
    document.getElementById('personnel-role-filter').addEventListener('change', function() {
        roleFilter = this.value;
        currentPage = 1; // Réinitialiser à la première page
        loadPersonnel();
    });

    // Gestionnaire pour la pagination
    document.getElementById('prev-page').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            loadPersonnel();
        }
    });

    document.getElementById('next-page').addEventListener('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            loadPersonnel();
        }
    });

    // Délégation d'événements pour les actions dynamiques
    document.getElementById('personnel-table-body').addEventListener('click', function(e) {
        // Gestion de la suppression
        if (e.target.closest('.delete-user-btn')) {
            const row = e.target.closest('tr');
            const userId = row.dataset.employeeId;
            const userName = row.querySelector('.employee-name').textContent;
            showDeleteModal(userId, userName);
        }
        
        // Gestion de l'édition (si nécessaire)
        if (e.target.closest('.edit-user-btn')) {
            // Logique d'édition si nécessaire
        }
    });
    
    // Gestionnaire de changement de rôle
    document.getElementById('personnel-table-body').addEventListener('change', function(e) {
        if (e.target.classList.contains('employee-role-select')) {
            const userId = e.target.closest('tr').dataset.employeeId;
            const newRole = e.target.value;
            updateUserRole(userId, newRole);
        }
    });

    // Gestionnaires pour le modal de suppression - Réécriture pour s'assurer qu'ils fonctionnent
    document.getElementById('cancel-delete-btn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Bouton Annuler cliqué");
        hideDeleteModal();
    });

    // Vérifier si un message flash existe dans le localStorage
    checkFlashMessage();

    // Fonction pour charger le personnel avec filtres et pagination
    function loadPersonnel() {
        if (!selectedRestaurantId) return;

        // Afficher un indicateur de chargement
        const tableBody = document.getElementById('personnel-table-body');
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4">Chargement...</td></tr>';

        fetch(`/gerant/users?restaurant_id=${selectedRestaurantId}&role=${roleFilter}&search=${searchQuery}&page=${currentPage}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                updatePersonnelTable(data.users);
                updatePagination(data.pagination);
            })
            .catch(error => {
                console.error('Erreur:', error);
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-red-500">Erreur lors du chargement des données</td></tr>';
            });
    }

    // Mettre à jour la table avec les données reçues
    function updatePersonnelTable(users) {
        const tableBody = document.getElementById('personnel-table-body');
        tableBody.innerHTML = '';

        if (users.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4">Aucun utilisateur trouvé</td></tr>';
            return;
        }

        users.forEach(user => {
            const row = document.createElement('tr');
            row.dataset.employeeId = user.id;
            row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700/30';

            row.innerHTML = `
                <td class="px-4 py-3">
                    <div class="flex items-center">
                        <img src="${user.avatar}" alt="${user.name}" class="w-10 h-10 rounded-full mr-3 object-cover">
                        <div>
                            <div class="font-medium text-sm text-gray-900 dark:text-gray-100 employee-name">${user.name}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">ID: #${user.id}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="text-sm text-gray-700 dark:text-gray-300">${user.email}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">${user.phone || 'Non renseigné'}</div>
                </td>
                <td class="px-4 py-3">
                    <select class="employee-role-select text-sm px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-full max-w-[120px]">
                        <option value="client" ${user.role === 'client' ? 'selected' : ''}>Client</option>
                        <option value="serveur" ${user.role === 'serveur' ? 'selected' : ''}>Serveur</option>
                        <option value="cuisinier" ${user.role === 'cuisinier' ? 'selected' : ''}>Cuisinier</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <div class="flex space-x-1">
                        <button type="button" class="delete-user-btn p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    // Mettre à jour les contrôles de pagination
    function updatePagination(pagination) {
        if (!pagination) return;

        const paginationInfo = document.getElementById('pagination-info');
        const prevButton = document.getElementById('prev-page');
        const nextButton = document.getElementById('next-page');
        const pageButtons = document.getElementById('page-buttons');

        // Mettre à jour l'information sur la pagination
        paginationInfo.textContent = `Affichage de ${pagination.from}-${pagination.to} employés sur ${pagination.total}`;

        // Mettre à jour les boutons de page
        totalPages = pagination.last_page;
        currentPage = pagination.current_page;

        // Activer/désactiver les boutons précédent/suivant
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;

        // Générer les boutons de page
        pageButtons.innerHTML = '';
        
        // Déterminer les pages à afficher
        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(totalPages, startPage + 2);
        
        if (endPage - startPage < 2) {
            startPage = Math.max(1, endPage - 2);
        }

        for (let i = startPage; i <= endPage; i++) {
            const button = document.createElement('button');
            button.className = i === currentPage 
                ? 'px-3 py-1 rounded border border-blue-500 bg-blue-500 text-white' 
                : 'px-3 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600';
            button.textContent = i;
            button.addEventListener('click', function() {
                currentPage = i;
                loadPersonnel();
            });
            pageButtons.appendChild(button);
        }
    }

    // Fonction pour mettre à jour le rôle d'un utilisateur
    function updateUserRole(userId, newRole) {
        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('role', newRole);

        fetch('/gerant/users/update-role', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: userId,
                role: newRole
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Rôle mis à jour', `Le rôle a été changé en "${newRole}"`);
            } else {
                showAlert('error', 'Erreur', data.message || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('error', 'Erreur réseau', 'Impossible de mettre à jour le rôle');
        });
    }

    // Afficher le modal de suppression
    function showDeleteModal(userId, userName) {
        userToDelete = userId;
        document.getElementById('employee-name-placeholder').textContent = userName;
        const deleteForm = document.getElementById('delete-user-form');
        deleteForm.action = `/gerant/users/${userId}`;
        
        // Bloquer le défilement de la page pendant que le modal est affiché
        document.body.style.overflow = 'hidden';
        
        // Afficher le modal
        document.getElementById('delete-modal').classList.remove('hidden');
        document.getElementById('delete-modal').classList.add('flex');
    }

    // Cacher le modal de suppression et restaurer le défilement de la page
    function hideDeleteModal() {
        userToDelete = null;
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Restaurer le défilement de la page
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '0';
    }

    // Vérifier si un restaurant est déjà sélectionné lors du chargement initial
    const restaurantSelector = document.getElementById('header-restaurant-selector');
    if (restaurantSelector.value) {
        selectedRestaurantId = restaurantSelector.value;
        loadPersonnel();
    }

    // Configuration du formulaire de suppression pour utiliser AJAX au lieu de soumettre directement
    const deleteForm = document.getElementById('delete-user-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire
            
            const form = this;
            const userId = userToDelete;
            const userRow = document.querySelector(`tr[data-employee-id="${userId}"]`);
            
            // Envoyer une requête AJAX au lieu d'une soumission de formulaire standard
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Cacher le modal
                hideDeleteModal();
                
                if (data.success) {
                    // Afficher l'alerte de succès
                    showAlert('success', 'Succès', data.message);
                    
                    // Supprimer visuellement la ligne de l'utilisateur sans recharger toute la liste
                    if (userRow) {
                        userRow.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                        setTimeout(() => {
                            userRow.remove();
                            
                            // Vérifier si la table est vide
                            if (document.querySelectorAll('#personnel-table-body tr').length === 0) {
                                document.getElementById('personnel-table-body').innerHTML = 
                                    '<tr><td colspan="4" class="text-center py-4">Aucun utilisateur trouvé</td></tr>';
                            }
                        }, 500);
                    }
                } else {
                    // Afficher l'alerte d'erreur
                    showAlert('error', 'Erreur', data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                hideDeleteModal();
                showAlert('error', 'Erreur réseau', 'Impossible de supprimer l\'utilisateur');
            });
        });
    }
});

// Fonction pour vérifier et afficher les messages flash stockés dans localStorage
function checkFlashMessage() {
    const flashMessage = localStorage.getItem('flashMessage');
    if (flashMessage) {
        const messageData = JSON.parse(flashMessage);
        showAlert(messageData.type, messageData.title, messageData.message);
        localStorage.removeItem('flashMessage'); // Supprimer après affichage
    }
}

// Fonction pour afficher les alertes avec une animation moderne
function showAlert(type, title, message) {
    // Supprimer les alertes existantes
    const existingAlerts = document.querySelectorAll('.custom-alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Créer une nouvelle alerte
    const alertElement = document.createElement('div');
    
    // Déterminer les couleurs et l'icône en fonction du type
    let bgColor, textColor, icon, borderColor;
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-50 dark:bg-green-900/20';
            textColor = 'text-green-800 dark:text-green-200';
            borderColor = 'border-green-500';
            icon = '<i class="fas fa-check-circle text-2xl text-green-500 dark:text-green-400"></i>';
            break;
        case 'error':
            bgColor = 'bg-red-50 dark:bg-red-900/20';
            textColor = 'text-red-800 dark:text-red-200';
            borderColor = 'border-red-500';
            icon = '<i class="fas fa-exclamation-circle text-2xl text-red-500 dark:text-red-400"></i>';
            break;
        default:
            bgColor = 'bg-blue-50 dark:bg-blue-900/20';
            textColor = 'text-blue-800 dark:text-blue-200';
            borderColor = 'border-blue-500';
            icon = '<i class="fas fa-info-circle text-2xl text-blue-500 dark:text-blue-400"></i>';
    }
    
    // Définir les classes et le contenu de l'alerte
    alertElement.className = `custom-alert fixed top-4 right-4 flex items-start p-4 ${bgColor} border-l-4 ${borderColor} rounded-md shadow-lg z-[9999] transform transition-all duration-500 ease-in-out translate-x-full`;
    alertElement.innerHTML = `
        <div class="mr-3 flex-shrink-0">
            ${icon}
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold ${textColor}">${title}</h4>
            <p class="text-xs mt-1 ${textColor}">${message}</p>
        </div>
        <button type="button" class="ml-4 ${textColor} hover:text-gray-600 dark:hover:text-gray-300 self-start" onclick="this.parentElement.classList.add('translate-x-full'); setTimeout(() => this.parentElement.remove(), 500);">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Ajouter l'alerte au document
    document.body.appendChild(alertElement);
    
    // Afficher l'alerte avec animation
    setTimeout(() => {
        alertElement.classList.remove('translate-x-full');
    }, 10);
    
    // Supprimer automatiquement après 5 secondes
    setTimeout(() => {
        alertElement.classList.add('translate-x-full');
        setTimeout(() => alertElement.remove(), 500);
    }, 5000);
}
</script>