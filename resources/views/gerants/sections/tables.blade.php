{{-- resources/views/gerants/sections/tables.blade.php --}}
<div id="section-tables" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6">Gestion des Tables</h2>

    {{-- Plan de salle --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h2 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-chair text-blue-500 mr-2"></i>
                Plan de salle en temps réel
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                <button id="btn-add-table" class="text-sm text-blue-500 hover:text-blue-700 dark:hover:text-blue-300 flex items-center whitespace-nowrap">
                    <i class="fas fa-plus-circle mr-1"></i> Ajouter table
                </button>
                <select id="floor-selector" class="text-sm px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">Tous les étages</option>
                    <option value="ground">Rez-de-chaussée</option>
                    <option value="terrace">Terrasse</option>
                    <option value="private">Espace privé</option>
                </select>
            </div>
        </div>

        {{-- Légende --}}
        <div class="mb-4 flex flex-wrap gap-x-4 gap-y-2">
            {{-- ... (contenu de la légende) ... --}}
             <div class="flex items-center"><div class="w-3 h-3 rounded-full bg-green-500 mr-1.5"></div><span class="text-xs">Disponible</span></div>
             <div class="flex items-center"><div class="w-3 h-3 rounded-full bg-blue-500 mr-1.5"></div><span class="text-xs">Occupée</span></div>
             <div class="flex items-center"><div class="w-3 h-3 rounded-full bg-amber-500 mr-1.5"></div><span class="text-xs">Commande</span></div>
             <div class="flex items-center"><div class="w-3 h-3 rounded-full bg-red-500 mr-1.5"></div><span class="text-xs">Paiement</span></div>
             <div class="flex items-center"><div class="w-3 h-3 rounded-full bg-purple-500 mr-1.5"></div><span class="text-xs">Réservée</span></div>
        </div>

        {{-- Conteneur du plan --}}
        <div class="relative overflow-auto p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50" style="height: 500px;">
            <div id="restaurant-map" class="min-w-[800px] h-full relative">
                {{-- Éléments fixes (Entrée, Bar, etc.) --}}
                <div class="absolute inset-0 pointer-events-none select-none">
                    <div class="absolute top-5 left-5 w-32 h-16 border border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs font-medium text-gray-400 dark:text-gray-500 rounded bg-white/50 dark:bg-gray-800/50">Entrée</div>
                    <div class="absolute top-5 right-5 w-32 h-16 border border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs font-medium text-gray-400 dark:text-gray-500 rounded bg-white/50 dark:bg-gray-800/50">Toilettes</div>
                    <div class="absolute bottom-5 right-5 w-52 h-24 border border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs font-medium text-gray-400 dark:text-gray-500 rounded bg-white/50 dark:bg-gray-800/50">Bar</div>
                    <div class="absolute bottom-5 left-5 w-52 h-24 border border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs font-medium text-gray-400 dark:text-gray-500 rounded bg-white/50 dark:bg-gray-800/50">Cuisine</div>
                </div>
                {{-- Conteneur où le JS placera les tables --}}
                <div id="tables-container" class="absolute inset-0">
                    {{-- Les tables seront ajoutées ici par JavaScript --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des tables --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
         <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h2 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 flex-shrink-0">
                <i class="fas fa-list text-blue-500 mr-2"></i>
                Liste des tables
            </h2>
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <input type="text" id="table-search" placeholder="Rechercher (N°, Serveur)..." class="pl-10 pr-4 py-2 rounded-lg text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-48">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select id="status-filter" class="text-sm px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="available">Disponible</option>
                    <option value="occupied">Occupée</option>
                    <option value="ordered">Commande</option>
                    <option value="payment">Paiement</option>
                    <option value="reserved">Réservée</option>
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
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Depuis</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Serveur</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody id="tables-list">
                    {{-- La liste sera remplie par JavaScript --}}
                    {{-- Vous pourriez pré-remplir avec Blade si les données viennent du serveur --}}
                     {{-- Exemple de ligne (pourrait être dans une boucle @foreach($tables as $table)) --}}
                     {{-- <tr class="border-b border-gray-100 dark:border-gray-800"> ... </tr> --}}
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
                        <option value="ground">Rez-de-chaussée</option>
                        <option value="terrace">Terrasse</option>
                        <option value="private">Espace privé</option>
                    </select>
                </div>
                 <div>
                    <label for="table-type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type de table</label>
                    <select id="table-type" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="round">Ronde</option>
                        <option value="rect">Rectangulaire</option>
                        <option value="booth">Booth</option>
                    </select>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position sur le plan (X, Y)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" id="table-x" placeholder="X" class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <input type="number" id="table-y" placeholder="Y" class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Laisser vide pour un placement automatique (aléatoire)</p>
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