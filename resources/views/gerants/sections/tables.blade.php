{{-- resources/views/gerants/sections/tables.blade.php --}}
<div id="section-tables" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6">Gestion des Tables</h2>

    {{-- Liste des tables --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
         <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h2 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-list text-blue-500 mr-2"></i>
                Liste des tables
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                <button id="btn-add-table" class="text-sm text-blue-500 hover:text-blue-700 dark:hover:text-blue-300 flex items-center whitespace-nowrap">
                    <i class="fas fa-plus-circle mr-1"></i> Ajouter table
                </button>
                <div class="relative">
                    <input type="text" id="table-search" placeholder="Rechercher (N°)..." class="pl-10 pr-4 py-2 rounded-lg text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-48">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select id="status-filter" class="text-sm px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="available">Disponible</option>
                    <option value="occupied">Occupée</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Numéro</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Capacité</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Zone</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody id="tables-list">
                    {{-- La liste sera remplie par JavaScript --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Ajout/Modification Table --}}
    <div id="table-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-auto max-h-[90vh] overflow-y-auto">
            <h3 id="table-modal-title" class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ajouter une table</h3>
            <div class="space-y-4">
                {{-- Champs du formulaire --}}
                <div>
                    <label for="table-number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de table *</label>
                    <input type="number" id="table-number" min="1" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                 <div>
                    <label for="table-capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Capacité (personnes) *</label>
                    <input type="number" id="table-capacity" min="1" max="20" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                 <div>
                    <label for="table-zone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Zone</label>
                    <select id="table-zone" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="SallePrincipale">SallePrincipale</option>
                        <option value="Terrasse">Terrasse</option>
                        <option value="Vip">Vip</option>
                    </select>
                </div>
            </div>
            {{-- Boutons de la modal --}}
            <div class="mt-6 flex justify-end gap-3">
                <button id="cancel-table-modal" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                    Annuler
                </button>
                <button id="save-table" type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Confirmation Suppression Table --}}
    <div id="delete-table-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
         <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-auto">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Supprimer cette table ?</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Êtes-vous sûr de vouloir supprimer la table <span id="delete-table-number" class="font-semibold"></span> ? Cette action est irréversible.
                </p>
                <div class="mt-6 flex justify-center gap-3">
                    <button id="cancel-delete-table" type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                        Annuler
                    </button>
                    <button id="confirm-delete-table" type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>