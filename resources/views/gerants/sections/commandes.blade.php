{{-- resources/views/gerants/sections/commandes.blade.php --}}
<div id="section-commandes" class="section-content p-6 hidden">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Commandes</h2>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 gap-2">
            <h3 class="flex items-center font-semibold text-gray-800 dark:text-gray-200 text-lg">
                <i class="fas fa-concierge-bell text-blue-500 mr-2"></i> {{-- Changed icon --}}
                Commandes en Cours / Récentes
            </h3>
             {{-- Optionnel: Filtres (Statut, Serveur, Zone) --}}
             <div class="flex items-center space-x-2">
                 <select class="text-xs p-1 border rounded dark:bg-gray-700 dark:border-gray-600">
                     <option>Tous statuts</option>
                     <option>En attente</option>
                     <option>En préparation</option>
                     <option>Prête</option>
                     <option>Servie</option>
                     <option>Retardée</option>
                 </select>
                 <button class="text-xs p-1 px-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                     <i class="fas fa-sync-alt mr-1"></i> Actualiser
                 </button>
             </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Table</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Statut</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Temps Écoulé</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Serveur</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Aperçu Commande</th>
                        <th class="px-4 py-2 text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                     {{-- Les données réelles viendraient d'une boucle @foreach($commandes as $commande) --}}
                     {{-- Données exemples : --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">Table 3</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300">En préparation</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-sm text-amber-600 dark:text-amber-400">18 min</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Thomas D.</td>
                         <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 italic">2x Steak Frites, 1x Salade...</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Voir Détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-orange-500 hover:bg-orange-600 text-white rounded" title="Marquer comme Prête">
                                    <i class="fas fa-bell"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                     <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">Table 8</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300">Servi</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-sm text-gray-500 dark:text-gray-400">12 min <span class="text-xs">(total)</span></td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Marie S.</td>
                         <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 italic">1x Pizza Reine, 1x Eau...</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Voir Détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                {{-- Pas d'action si déjà servi ? Ou bouton "encaisser" ? --}}
                                <button class="p-1.5 text-xs bg-gray-400 text-white rounded cursor-not-allowed" title="Servi" disabled>
                                    <i class="fas fa-check-double"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-4 py-3 font-medium text-sm text-gray-900 dark:text-gray-100">Table 10</td>
                         <td class="px-4 py-3">
                             <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 animate-pulse">Retardée</span>
                         </td>
                        <td class="px-4 py-3 font-medium text-sm text-red-600 dark:text-red-400">25 min</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Thomas D.</td>
                         <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 italic">1x Burger, 1x Pâtes...</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                <button class="p-1.5 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded" title="Voir Détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-1.5 text-xs bg-red-500 hover:bg-red-600 text-white rounded" title="Prioriser / Alerter Cuisine">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>